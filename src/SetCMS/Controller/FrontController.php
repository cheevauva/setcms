<?php

namespace SetCMS\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\FactoryInterface;
use SetCMS\Servant\ParseBodyRequestServant;
use SetCMS\Servant\BuildResponseByMixedValueServant;
use SetCMS\Servant\MatchRouteByRequestServant;
use SetCMS\Controller\Servant\BuildByTargetStringServant;
use SetCMS\Servant\RetrieveArgumentsByMethodServant;

class FrontController
{

    public function resolve(ServerRequestInterface $request, ResponseInterface $response, FactoryInterface $factory): ResponseInterface
    {
        try {
            $matchRequest = MatchRouteByRequestServant::factory($factory);
            $matchRequest->apply($request);
            $matchRequest->serve();
            
            foreach ($matchRequest->routerMatch->params as $pName => $pValue) {
                $request = $request->withAttribute($pName, $pValue);
            }

            $parseBody = ParseBodyRequestServant::factory($factory);
            $parseBody->request = $request;
            $parseBody->serve();

            $controllerBuilder = BuildByTargetStringServant::factory($factory);
            $controllerBuilder->target = $matchRequest->routerMatch->target;
            $controllerBuilder->serve();

            $methodArgumentsBuilder = RetrieveArgumentsByMethodServant::factory($factory);
            $methodArgumentsBuilder->apply($controllerBuilder->method);
            $methodArgumentsBuilder->apply($parseBody->request);
            $methodArgumentsBuilder->apply($response);
            $methodArgumentsBuilder->serve();

            $output = $controllerBuilder->method->invokeArgs($controllerBuilder->controller, $methodArgumentsBuilder->arguments);
        } catch (\Throwable $ex) {
            $output = $ex;
        }

        $prepareResponse = BuildResponseByMixedValueServant::factory($factory);
        $prepareResponse->request = $parseBody->request;
        $prepareResponse->mixedValue = $output;
        $prepareResponse->serve();

        return $prepareResponse->response;
    }

}
