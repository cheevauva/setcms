<?php

declare(strict_types=1);

namespace SetCMS\Controller\Event;

use Psr\Http\Message\ServerRequestInterface;

class FrontControllerResolveEvent
{

    use \SetCMS\EventTrait;

    public function __construct(public ServerRequestInterface $request)
    {
        
    }

}
