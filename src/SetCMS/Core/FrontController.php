<?php

namespace SetCMS\Core;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;
use SetCMS\Contract\Factory;
use SetCMS\Servant\ViewRender;
use SetCMS\Core\DAO\CoreReflectionMethodRetrieveByServerRequestDAO;
use SetCMS\Contract\NotFound;
use SetCMS\Contract\Forbidden;
use SetCMS\Controller\Hook\ParseBodyHook;
use SetCMS\Controller\Hook\FrontControllerResolveHook;

class FrontController
{

    use \SetCMS\QuickTrait;

    public function resolve(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $request = (new ParseBodyHook($request))->dispatch()->request;
        $request = (new FrontControllerResolveHook($request))->dispatch()->request;

        try {
            $retrieveMethod = CoreReflectionMethodRetrieveByServerRequestDAO::make($this->factory());
            $retrieveMethod->response = $response;
            $retrieveMethod->request = $request;
            $retrieveMethod->serve();

            $output = $retrieveMethod->reflectionMethod->invokeArgs($retrieveMethod->reflectionObject, $retrieveMethod->reflectionArguments);
        } catch (\Throwable $ex) {
            $response = $response->withStatus(500);
            $output = $ex;
        }

        if ($output instanceof NotFound) {
            $response = $response->withStatus(404);
        }

        if ($output instanceof Forbidden) {
            $response = $response->withStatus(403);
        }


        if (is_null($output)) {
            $response->getBody()->write('Success!');
        } else {
            $render = ViewRender::make($this->factory());
            $render->request = $request;
            $render->mixedValue = $output;
            $render->serve();

            $response->getBody()->write($render->content);
        }

        return $response;
    }

}
