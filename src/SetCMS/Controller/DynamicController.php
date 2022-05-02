<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\FactoryInterface;
use SetCMS\Controller\Servant\ExecuteDynamicControllerServant;

abstract class DynamicController
{

    protected BuildByDynamicAttributeServant $controllerWithMethod;

    abstract protected function getSection(): string;

    public function resolve(ServerRequestInterface $request, ResponseInterface $response, FactoryInterface $factory)
    {
        $executer = ExecuteDynamicControllerServant::factory($factory);
        $executer->section = $this->getSection();
        $executer->module = $request->getAttribute('module');
        $executer->action = $request->getAttribute('action');
        $executer->apply($request);
        $executer->apply($response);
        $executer->serve();

        return $executer->mixedValue;
    }

}
