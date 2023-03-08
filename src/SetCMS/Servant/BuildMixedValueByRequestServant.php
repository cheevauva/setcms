<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Servant\MatchRouteByRequestServant;
use SetCMS\Servant\ParseBodyRequestServant;
use SetCMS\Controller\Servant\BuildByTargetStringServant;
use SetCMS\Servant\RetrieveArgumentsByMethodServant;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class BuildMixedValueByRequestServant implements Servant
{

    use \SetCMS\FactoryTrait;
    use \SetCMS\DITrait;

    public ServerRequestInterface $request;
    public ?ResponseInterface $response = null;
    public object $mixedValue;

    public function serve(): void
    {
        $newRequest = $this->request;

        $matchRequest = MatchRouteByRequestServant::make($this->factory());
        $matchRequest->apply($newRequest);
        $matchRequest->serve();

        foreach ($matchRequest->routerMatch->params as $pName => $pValue) {
            $newRequest = $newRequest->withAttribute($pName, $pValue);
        }

        $parseBody = ParseBodyRequestServant::make($this->factory());
        $parseBody->request = $newRequest;
        $parseBody->serve();

        $controllerBuilder = BuildByTargetStringServant::make($this->factory());
        $controllerBuilder->target = $matchRequest->routerMatch->target;
        $controllerBuilder->serve();

        $methodArgumentsBuilder = RetrieveArgumentsByMethodServant::make($this->factory());
        $methodArgumentsBuilder->apply($controllerBuilder->method);
        $methodArgumentsBuilder->apply($parseBody->request);
        if ($this->response) {
            $methodArgumentsBuilder->apply($this->response);
        }
        $methodArgumentsBuilder->serve();

        $this->mixedValue = $controllerBuilder->method->invokeArgs($controllerBuilder->controller, $methodArgumentsBuilder->arguments);
    }

}
