<?php

namespace SetCMS\Controller\Event;

use SetCMS\ControllerViaPSR7;
use Psr\Http\Message\ServerRequestInterface;

class ControllerOnBeforeServeEvent extends \UUA\Event
{

    use \SetCMS\Traits\EventTrait;

    public ControllerViaPSR7 $controller;
    public ServerRequestInterface $request;
}
