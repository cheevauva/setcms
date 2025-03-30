<?php

namespace SetCMS\Controller\Event;

use SetCMS\Controller;
use Psr\Http\Message\ServerRequestInterface;

class ControllerOnBeforeServeEvent extends \UUA\Event
{

    use \SetCMS\Traits\EventTrait;

    public Controller $controller;
    public ServerRequestInterface $request;
}
