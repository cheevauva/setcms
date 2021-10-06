<?php

namespace SetCMS;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\VarDoc;
use SetCMS\Router as Router;
use SetCMS\HttpStatusCode\HttpStatusCode;
use SetCMS\Model;
use SetCMS\Action;

class FrontController
{

    protected \Twig\Environment $twig;
    protected ContainerInterface $container;
    protected Router $router;
    protected ServerRequestInterface $request;
    protected array $config;
    protected string $basePath;

    public function __construct(ContainerInterface $container, Router $router, string $basePath, array $config)
    {
        $this->basePath = $basePath;
        $this->config = $config;
        $this->container = $container;
        $this->router = $router;
        $this->router->addRoutes(require $this->basePath . '/resources/routes.php');
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
        $twig->addFunction(new \Twig\TwigFunction('theme_path', function ($path) {
            return new \Twig\Markup(sprintf('themes/%s/%s', $this->config['theme'], $path), 'UTF-8');
        }));
        $twig->addFunction(new \Twig\TwigFunction('render', function ($template, $params = []) {
            $request = $this->withAttributes($this->request, $params);
            $model = $this->invokeAction(new Action($request));
            $content = $this->getTwig()->render($template, $model->toArray());

            return new \Twig\Markup($content, 'UTF-8');
        }));
        $twig->addFunction(new \Twig\TwigFunction('link', function (string $route, $params = []) {
            $self = $this->request->getServerParams()['SCRIPT_NAME'];
            $link = $self . $this->router->generate($route, $params);

            return new \Twig\Markup($link, 'UTF-8');
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

    protected function process(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $result = $this->router->match($request->getServerParams()['PATH_INFO'] ?? '/', $request->getServerParams()['REQUEST_METHOD']);

        if (!$result) {
            throw ModuleException::notFound('На найден указанный ресурс');
        }

        $request = $this->withAttributes($request, $result['params'] ?? []);
        $request = $this->withAttributes($request, $result['target'] ?? []);

        $this->request = $request;

        $action = new Action($request);
        $model = $this->invokeAction($action);

        if (stripos($action->getComment(), VarDoc::RESPONSE_HTML) !== false) {
            $template = sprintf('modules/%s/%s/%s.twig', $action->getModule(), $request->getAttribute('section', 'Index'), $action->getAction()->getName());
            $html = $this->getTwig()->render($template, $model->toArray());

            $response = $response->withHeader('Content-type', 'text/html');
            $response->getBody()->write($html);
        }

        if (stripos($action->getComment(), VarDoc::RESPONSE_JSON) !== false) {
            $response = $response->withHeader('Content-type', 'application/json');
            $response->getBody()->write($this->model2json($model));
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
