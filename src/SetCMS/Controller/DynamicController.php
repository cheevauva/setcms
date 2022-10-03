<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\FactoryInterface;
use SetCMS\Controller\Servant\ExecuteDynamicControllerServant;

abstract class DynamicController
{

    abstract protected function getSection(): string;

    public function dynamicAction(ServerRequestInterface $request, ResponseInterface $response, FactoryInterface $factory)
    {
        $executor = ExecuteDynamicControllerServant::make($factory);
        $executor->className = 'SetCMS\Module\{module}\{module}{section}Controller';
        $executor->section = $this->getSection();
        $executor->module = $request->getAttribute('module');
        $executor->action = $request->getAttribute('action');
        $executor->apply($request);
        $executor->apply($response);
        $executor->serve();
        
        return $executor->mixedValue;
    }

}
