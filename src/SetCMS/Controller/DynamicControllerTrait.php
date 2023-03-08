<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Contract\Factory;
use SetCMS\Controller\Servant\ExecuteDynamicControllerServant;

trait DynamicControllerTrait
{

    public function dynamicAction(ServerRequestInterface $request, ResponseInterface $response, Factory $factory)
    {
        $executor = ExecuteDynamicControllerServant::make($factory);
        $executor->className = static::class;
        $executor->action = $request->getAttribute('action');
        $executor->apply($request);
        $executor->apply($response);
        $executor->serve();

        return $executor->mixedValue;
    }

}
