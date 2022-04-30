<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\FactoryInterface;
use SetCMS\Servant\RetrieveArgumentsByMethodServant;
use SetCMS\Controller\Servant\BuildByDynamicAttributeServant;

abstract class DynamicController
{

    protected BuildByDynamicAttributeServant $controllerWithMethod;

    abstract protected function getSection(): string;

    public function resolve(ServerRequestInterface $request, ResponseInterface $response, FactoryInterface $factory)
    {
        $controllerBuilder = BuildByDynamicAttributeServant::factory($factory);
        $controllerBuilder->section = $this->getSection();
        $controllerBuilder->module = 'Post';
        $controllerBuilder->action = 'readBySlug';
        $controllerBuilder->serve();

        $methodArgumentsBuilder = RetrieveArgumentsByMethodServant::factory($factory);
        $methodArgumentsBuilder->apply($controllerBuilder->method);
        $methodArgumentsBuilder->apply($request);
        $methodArgumentsBuilder->apply($response);
        $methodArgumentsBuilder->serve();

        return $controllerBuilder->method->invokeArgs($controllerBuilder->controller, $methodArgumentsBuilder->arguments);
    }

}
