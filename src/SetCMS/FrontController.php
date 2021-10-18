<?php

namespace SetCMS;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Router as Router;
use SetCMS\HttpStatusCode\HttpStatusCode;
use SetCMS\Model;
use SetCMS\Action;
use SetCMS\Module\Users\UserDAO;
use SetCMS\Module\Users\User;
use SetCMS\Module\Users\UserException;
use SetCMS\Module\OAuth\OAuthService;
use SetCMS\RequestAttribute;

class FrontController
{

    protected \Twig\Environment $twig;
    protected ContainerInterface $container;
    protected Router $router;
    protected ServerRequestInterface $request;
    protected array $config;
    protected string $basePath;
    protected UserDAO $userDAO;
    protected ?User $currentUser = null;
    protected OAuthService $oauthService;

    public function __construct(ContainerInterface $container, string $basePath, array $config)
    {
        $this->container = $container;
        $this->router = $container->get(Router::class);
        $this->userDAO = $container->get(UserDAO::class);
        $this->oauthService = $container->get(OAuthService::class);
        $this->basePath = $basePath;
        $this->config = $config;
        $this->router->addRoutes(require $this->basePath . '/resources/routes.php');
        $this->headers = require $this->basePath . '/resources/headers.php';
    }

    public function execute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->request = $request;

        try {
            return $this->process($request, $response);
        } catch (\Exception $ex) {
            $code = 500;
            $reason = 'Внутренняя ошибка';
            $message = $ex->getMessage();
            $trace = $ex->getTraceAsString();

            if ($ex instanceof HttpStatusCode) {
                $code = $ex::CODE;
                $reason = $ex::REASON;
            }

            $contentType = $request->getServerParams()['HTTP_ACCEPT'] ?? 'text/html';

            $model = (new \SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelError);
            $model->message = $reason;
            $model->trace = $trace;
            $model->addMessage($message);

            if (strpos($contentType, 'json') !== false) {
                $contentType = 'application/json';
                $content = $this->model2json($model);
            } else {
                $contentType = 'text/html';
                $content = $this->getTwig($request)->render('error.twig', $model->toArray());
            }

            $response->getBody()->write($content);
            $response = $response->withHeader('Content-type', $contentType);
            $response = $response->withStatus($code, $reason);

            return $response;
        }
    }

    protected function invokeAction(Action $action): Model
    {
        return $action->getAction()->invokeArgs($this->container->get($action->getControllerClassName()), $action->getArguments());
    }

    protected function withAttributes(ServerRequestInterface $request, array $attributes): ServerRequestInterface
    {
        foreach ($attributes as $attribute => $attributeValue) {
            $request = $request->withAttribute($attribute, $attributeValue);
        }

        return $request;
    }

    protected function getCurrentUser(): ?User
    {
        if ($this->currentUser) {
            return $this->currentUser;
        }

        $token = $this->request->getAttribute(RequestAttribute::ACCESS_TOKEN);

        if ($token && !$this->currentUser) {
            try {
                $this->currentUser = $this->oauthService->getUserByAccessToken($token);
            } catch (\Exception $ex) {
                $this->currentUser = null;
            }
        }

        return $this->currentUser;
    }

    protected function isAdmin(): bool
    {
        if (!$this->getCurrentUser()) {
            return false;
        }

        if ($this->getCurrentUser()->isAdmin) {
            return true;
        }

        return in_array($this->getCurrentUser()->id, $this->config['admin_users'] ?? [], true);
    }

    protected function getTwig(): ?\Twig\Environment
    {
        if (!empty($this->twig)) {
            return $this->twig;
        }

        $loader = new \Twig\Loader\FilesystemLoader($this->basePath . '/resources/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => $this->basePath . '/cache/twig',
            'auto_reload' => true,
        ]);

        $theme = new Theme($this->config['theme'], $this->request, $this->router);
        $theme->currentModule = $this->request->getAttribute('module');
        $theme->currentUser = $this->getCurrentUser();
        $theme->baseUrl = dirname($this->request->getServerParams()['SCRIPT_NAME']);

        $twig->addGlobal('setcms', $theme);
        $twig->addFunction(new \Twig\TwigFunction('render', function ($template, $params = []) {
            $request = $this->withAttributes($this->request, $params);
            $model = $this->invokeAction(new Action($request));
            $content = $this->getTwig()->render($template, $model->toArray());

            return new \Twig\Markup($content, 'UTF-8');
        }));

        return $this->twig = $twig;
    }

    protected function getModelByRoute($route, ServerRequestInterface $request): \SetCMS\Model
    {
        $result = $this->router->match($route, 'GET');

        foreach ($result['params'] ?? [] as $param => $paramVal) {
            $request = $request->withAttribute($param, $paramVal);
        }

        $action = new Action($request);

        return $action->getAction()->invokeArgs($this->container->get($action->getControllerClassName()), $action->getArguments());
    }

    protected function csrfProtect(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->getHeaderLine('Authorization')) {
            return $response;
        }

        if ($request->getMethod() === 'GET') {
            $token = md5(microtime(true) . rand(1, 100000));
            return $response->withHeader('X-CSRF-Token', $token)->withHeader('Set-Cookie', sprintf('X-CSRF-Token=%s;Path=/;SameSite=Strict', $token));
        }

        if (in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH'], true)) {
            if (empty($request->getCookieParams()['X-CSRF-Token']) || empty($request->getHeader('X-CSRF-Token')[0])) {
                throw ModuleException::badRequest('Один из CSRF токенов пуст');
            }

            if ($request->getCookieParams()['X-CSRF-Token'] !== $request->getHeader('X-CSRF-Token')[0]) {
                throw ModuleException::badRequest('CSRF токены не совпадают');
            }
        }

        return $response;
    }

    protected function processAccessToken(ServerRequestInterface $request): ServerRequestInterface
    {
        $tokens = $this->oauthService->parseTokens(array_filter([
            $this->request->getHeaderLine('Authorization') ?? null,
            $this->request->getCookieParams()['X-SetCMS-AccessToken'] ?? null,
        ]));

        return $request->withAttribute(RequestAttribute::ACCESS_TOKEN, $tokens ? reset($tokens) : null);
    }

    protected function process(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $request = $this->processAccessToken($request);

        $result = $this->router->match($request->getServerParams()['PATH_INFO'] ?? '/', $request->getServerParams()['REQUEST_METHOD']);

        if (!$result) {
            throw ModuleException::notFound();
        }

        $request = $this->withAttributes($request, $result['params'] ?? []);
        $request = $this->withAttributes($request, $result['target'] ?? []);

        $this->request = $request;

        $action = new Action($request);

        if ($action->isCSRFProtectEnabled()) {
            $response = $this->csrfProtect($request, $response);
        }

        if ($action->isNeedAuth() && !$this->getCurrentUser()) {
            throw UserException::notAuthorized();
        }

        if ($action->isNeedNotAuth() && $this->getCurrentUser()) {
            throw UserException::alreadyAuthorized();
        }

        if ($action->isAdmin() && !$this->isAdmin()) {
            throw UserException::onlyAdmin();
        }

        $model = $this->invokeAction($action);

        if ($action->hasResponseHeaders()) {
            $callbackHeaderName = implode('.', [$action->getModule(), $action->getSection(), $action->getAction()->getName()]);
            $router = clone $this->router;
            $router->setBasePath($request->getServerParams()['SCRIPT_NAME']);
            $headerRequest = $request->withAttribute('model', $model)->withAttribute('router', $router);
            $response = $this->headers[$callbackHeaderName]($headerRequest, $response);
        }

        switch ($action->getContentType()) {
            case 'json':
                $response = $response->withHeader('Content-type', 'application/json');
                $response->getBody()->write($action->getWrapper() === 'json-none' ? json_encode($model->toArray(), JSON_UNESCAPED_UNICODE) : $this->model2json($model));
                break;
            case 'html':
                $template = sprintf('themes/%s/modules/%s/%s/%s.twig', $this->config['theme'], $action->getModule(), $action->getSection(), $action->getAction()->getName());
                $html = $this->getTwig()->render($template, $model->toArray());

                $response = $response->withHeader('Content-type', 'text/html');
                $response->getBody()->write($html);
                break;
        }

        return $response;
    }

    protected function model2json(\SetCMS\Model $model): string
    {
        return json_encode([
            'success' => empty($model->getMessages()),
            'result' => $model->toArray(),
            'messages' => $model->getMessages(),
        ], JSON_UNESCAPED_UNICODE);
    }

}
