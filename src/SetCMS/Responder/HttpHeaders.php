<?php

namespace SetCMS\Responder;

use Psr\Http\Message\ResponseInterface as Response;
use SetCMS\Responder\ResponderInterface;
use Psr\Http\Message\RequestInterface as Request;
use SetCMS\Router;
use Psr\Container\ContainerInterface as Container;
use SetCMS\Model;
use SetCMS\Action;

class HttpHeaders implements ResponderInterface
{

    use ResponderApplyTrait;

    protected Router $router;
    protected array $headers;
    protected Request $request;
    protected Model $model;

    public function __construct(Container $container)
    {
        $this->headers = $container->get('headers');
        $this->router = $container->get(Router::class);
    }

    public function prepareResponse(Response $response): Response
    {
        $router = clone $this->router;
        $router->setBasePath($this->request->getServerParams()['SCRIPT_NAME']);

        $request = $this->request->withAttribute('model', $this->model);
        $request = $request->withAttribute('router', $this->router);

        $response = $this->headers[$this->action->getCallbackHeaderName()]($request, $response);

        return $response;
    }

}
