<?php

namespace SetCMS;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Router as Router;
use SetCMS\HttpStatusCode\HttpStatusCode;
use SetCMS\Action;
use SetCMS\ACL;
use SetCMS\Module\Modules\ModuleDAO;
use SetCMS\Module\Themes\ThemeDAO;
use SetCMS\Module\Modules\ModuleException;
use SetCMS\EventDispatcher;
use SetCMS\Event\FrontControllerBeforeLaunchActionEvent as BeforeLaunchActionEvent;

class FrontController
{

    protected \Twig\Environment $twig;
    protected ContainerInterface $container;
    protected Router $router;
    protected ServerRequestInterface $request;
    protected array $config;
    protected string $basePath;
    protected ACL $acl;
    protected ModuleDAO $moduleDAO;
    protected ThemeDAO $themeDAO;
    protected Action $action;
    protected EventDispatcher $eventDispatcher;

    public function __construct(ContainerInterface $container, Router $router, ACL $acl, ModuleDAO $moduleDAO, ThemeDAO $themeDAO, Action $action, EventDispatcher $eventDispatcher)
    {
        $this->container = $container;
        $this->basePath = $container->get('basePath');
        $this->config = $container->get('config');
        $this->headers = $container->get('headers');
        $this->router = $router;
        $this->acl = $acl;
        $this->moduleDAO = $moduleDAO;
        $this->themeDAO = $themeDAO;
        $this->action = $action;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        switch ($request->getMethod()) {
            case 'PUT':
            case 'DELETE':
            case 'POST':
                if (strpos($request->getHeaderLine('Accept'), 'application/json') !== false && $request->getBody()->getContents()) {
                    $request = $request->withParsedBody(json_decode($request->getBody()->getContents(), true));
                }
                break;
        }

        $this->request = $request;

        try {
            return $this->process($request, $response);
        } catch (\Exception $ex) {
            $code = 500;
            $message = 'Внутренняя ошибка';
            $reason = $ex->getMessage();
            $trace = $ex->getTraceAsString();

            if ($ex instanceof HttpStatusCode) {
                $code = $ex::CODE;
                $reason = $ex->getMessage() ? $ex->getMessage() : $ex::REASON;
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

    protected function withAttributes(ServerRequestInterface $request, array $attributes): ServerRequestInterface
    {
        foreach ($attributes as $attribute => $attributeValue) {
            $request = $request->withAttribute($attribute, $attributeValue);
        }

        return $request;
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

        $theme = $this->themeDAO->get($this->config['theme']);
        $theme->config = $this->config;
        $theme->setRouter($this->router);
        $theme->setRequest($this->request);
        $theme->setModuleFinder($this->moduleDAO);
        $theme->currentModule = $this->request->getAttribute('module');
        $theme->currentUser = $this->request->getAttribute('user');

        $twig->addGlobal('setcms', $theme);
        $twig->addFunction(new \Twig\TwigFunction('render', function ($template, $params = []) {
            $request = $this->withAttributes($this->request, $params);
            $model = (new Action($request))();
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

        return $this->createAction($request)();
    }

    protected function createAction(ServerRequestInterface $request): Action
    {
        return (clone $this->action)->withRequest($request);
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

        if (in_array($request->getMethod(), ['POST'], true)) {
            if (empty($request->getCookieParams()['X-CSRF-Token']) || empty($request->getHeader('X-CSRF-Token')[0])) {
                throw ModuleException::badRequest('Один из CSRF токенов пуст');
            }

            if ($request->getCookieParams()['X-CSRF-Token'] !== $request->getHeader('X-CSRF-Token')[0]) {
                throw ModuleException::badRequest('CSRF токены не совпадают');
            }
        }

        return $response;
    }

    protected function process(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $result = $this->router->match($request->getServerParams()['PATH_INFO'] ?? '/', $request->getServerParams()['REQUEST_METHOD']);

        if (!$result) {
            throw ModuleException::notFound();
        }

        $request = $this->withAttributes($request, $result['params'] ?? []);
        $request = $this->withAttributes($request, $result['target'] ?? []);

        $this->request = $request;

        $action = $this->createAction($request);

        if ($action->isCSRFProtectEnabled()) {
            $response = $this->csrfProtect($request, $response);
        }

        $request = $this->eventDispatcher->dispatch(new BeforeLaunchActionEvent($action, $request))->request;

        $action->withRequest($request);

        $this->request = $request;

        $model = $action();

        foreach ($action->getContentType() as $type) {
            switch ($type) {
                case 'http-headers':
                    $router = clone $this->router;
                    $router->setBasePath($request->getServerParams()['SCRIPT_NAME']);
                    $headerRequest = $request->withAttribute('model', $model)->withAttribute('router', $router);
                    $response = $this->headers[$action->getCallbackHeaderName()]($headerRequest, $response);
                    break;
                case 'json':
                    $response = $response->withHeader('Content-type', 'application/json');
                    $response->getBody()->write($action->getWrapper() === 'json-none' ? json_encode($model->toArray(), JSON_UNESCAPED_UNICODE) : $this->model2json($model));
                    break;
                case 'html':
                    $html = $this->getTwig()->render($action->getTemplate($this->config['theme']), $model->toArray());

                    $response = $response->withHeader('Content-type', 'text/html');
                    $response->getBody()->write($html);
                    break;
            }
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
