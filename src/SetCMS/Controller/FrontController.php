<?php

namespace SetCMS\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;
use SetCMS\Contract\Factory;
use SetCMS\Controller\Event\FrontControllerResolveEvent;
use SetCMS\Servant\BuildResponseByMixedValueServant;
use SetCMS\Servant\BuildMixedValueByRequestServant;

class FrontController
{

    public function resolve(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container): ResponseInterface
    {
        $factory = $container->get(Factory::class);
        $newRequest = (new FrontControllerResolveEvent($request))->dispatch()->request;

        try {
            $builder = BuildMixedValueByRequestServant::make($factory);
            $builder->response = $response;
            $builder->request = $newRequest;
            $builder->serve();
            $output = $builder->mixedValue;
        } catch (\Exception $ex) {
            $output = $ex;
        }

        $prepareResponse = BuildResponseByMixedValueServant::make($factory);
        $prepareResponse->request = $newRequest;
        $prepareResponse->mixedValue = $output;
        $prepareResponse->serve();

        return $prepareResponse->response;
    }

}
