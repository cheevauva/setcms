<?php

namespace SetCMS;

use SetCMS\ModuleException;
use SetCMS\Module;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\VarDoc;
use SetCMS\Router as AltoRouter;

class FrontController
{

    protected \Twig\Environment $twig;
    protected ContainerInterface $container;
    protected AltoRouter $router;
    protected ServerRequestInterface $request;

    public function __construct(ContainerInterface $container, AltoRouter $router)
    {
        $this->container = $container;
        $this->router = $router;
        $this->router->addRoutes(require 'resources/routes.php');
    }

    public function execute(ServerRequestInterface $request): ResponseInterface
    {

        $accept = stripos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false ? 'json' : 'html';

        try {
            return $this->process($request);
        } catch (\Exception $ex) {
            if ($accept === 'html') {
                header('Content-type: text/html');
                echo $this->getTwig()->render('uncatched.twig', [
                    'message' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ]);
                die;
            }
            if ($accept === 'json') {
                header('Content-type: application/json');
                echo json_encode([
                    'result' => null,
                    'messages' => [
                        [
                            'message' => $ex->getMessage(),
                            'field' => null,
                        ]
                    ],
                ], JSON_UNESCAPED_UNICODE);
                die;
            }
        }
    }

    protected function invokeAction(\SetCMS\Action $action)
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

    protected function getTwig($request = null): ?\Twig\Environment
    {
        if (!empty($this->twig)) {
            return $this->twig;
        }
        $loader = new \Twig\Loader\FilesystemLoader('resources/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => 'cache/twig',
            'auto_reload' => true,
        ]);
        $twig->addFunction(new \Twig\TwigFunction('render', function ($template, $params = []) {
            $request = $this->withAttributes($this->request, $params);
            $model = $this->invokeAction($this->processByParams($request));
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

        $action = $this->processByParams($request);

        return $action->getAction()->invokeArgs($this->container->get($action->getControllerClassName()), $action->getArguments());
    }

    protected function processByParams(ServerRequestInterface $request)
    {
        $section = $request->getAttribute('section', 'Index');
        $module = $request->getAttribute('module', '');
        $method = $request->getAttribute('method', 'GET');
        $action = $request->getAttribute('action', 'index');

        return new \SetCMS\Action($module, $action, $request);
    }

    protected function process(ServerRequestInterface $request): ResponseInterface
    {
        $result = $this->router->match($request->getServerParams()['PATH_INFO'] ?? '/', $request->getServerParams()['REQUEST_METHOD']);

        $request = $this->withAttributes($request, $result['params'] ?? []);
        $request = $this->withAttributes($request, $result['target'] ?? []);

        $this->request = $request;

        $action = $this->processByParams($request);
        $model = $this->invokeAction($action);

        if (stripos($action->getComment(), VarDoc::RESPONSE_HTML) !== false) {
            $template = sprintf('modules/%s/%s.twig', $action->getModule(), $action->getAction()->getName());
            $html = $this->getTwig($request)->render($template, $model->toArray());

            $response = (new \Laminas\Diactoros\Response);
            $response = $response->withHeader('Content-type', 'text/html');
            $response->getBody()->write($html);
        }

        if (stripos($action->getComment(), VarDoc::RESPONSE_JSON) !== false) {
            $content = json_encode([
                'success' => empty($model->getMessages()),
                'result' => $model->toArray(),
                'messages' => $model->getMessages(),
            ], JSON_UNESCAPED_UNICODE);

            $response = (new \Laminas\Diactoros\Response);
            $response = $response->withHeader('Content-type', 'application/json');
            $response->getBody()->write($content);
        }

        return $response;
    }

}
