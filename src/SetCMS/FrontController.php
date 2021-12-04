<?php

namespace SetCMS;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Router as Router;
use SetCMS\HttpStatusCode\HttpStatusCode;
use SetCMS\Action;
use SetCMS\ACL;
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
    protected Action $action;
    protected EventDispatcher $eventDispatcher;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->basePath = $container->get('basePath');
        $this->config = $container->get('config');
        $this->headers = $container->get('headers');
        $this->router = $container->get(Router::class);
        $this->acl = $container->get(ACL::class);
        $this->action = $container->get(Action::class);
        $this->eventDispatcher = $container->get(EventDispatcher::class);
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
            echo $ex->getMessage(); // @todo надо сделать модуль для ошибок
            die;
            $code = 500;
            $message = 'Внутренняя ошибка';
            $reason = $ex->getMessage();
            $trace = $ex->getTraceAsString();

            if ($ex instanceof HttpStatusCode) {
                $code = $ex::CODE;
                $reason = $ex->getMessage() ? $ex->getMessage() : $ex::REASON;
            }

            $model = (new \SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelError);
            $model->message = $reason;
            $model->trace = $trace;
            $model->addMessage($message);

            $contentTypes = [];
            $contentType = $request->getServerParams()['HTTP_ACCEPT'] ?? 'text/html';

            if (strpos($contentType, 'json') !== false) {
                $contentTypes[] = 'json';
            }
            if (strpos($contentType, 'html') !== false) {
                $contentTypes[] = 'html';
            }

            if (empty($contentTypes)) {
                $contentTypes[] = 'html';
            }

            $action = $this->createAction($request);

            $response = $this->prepareResponse($action, $model, $request, $response);
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
        return (clone $this->action)->apply($request);
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

        $request = (new BeforeLaunchActionEvent($action, $request))->dispatch($this->eventDispatcher)->request;

        $action->apply($request);

        $this->request = $request;

        $model = $action();

        return $this->prepareResponse($action, $model, $request, $response);
    }

    public function createResponder(string $type): Responder\ResponderInterface
    {
        switch ($type) {
            case 'html':
                return clone $this->container->get(Responder\Html::class);
            case 'json':
                return clone $this->container->get(Responder\Json::class);
            case 'http-headers':
                return clone $this->container->get(Responder\HttpHeaders::class);
        }
    }

    protected function prepareResponse($action, $model, $request, $response)
    {
        foreach ($action->getContentTypes() as $type) {
            $responder = $this->createResponder($type);
            $responder->apply($action);
            $responder->apply($model);
            $responder->apply(clone $this->router);
            $responder->apply($request);

            $response = $responder->prepareResponse($response);
        }

        return $response;
    }

}
