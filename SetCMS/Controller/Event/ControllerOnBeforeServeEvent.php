<?php

namespace SetCMS\Controller\Event;

use SetCMS\ControllerViaPSR7;

class ControllerOnBeforeServeEvent extends \UUA\Event
{

    use \SetCMS\Traits\EventTrait;

    public ControllerViaPSR7 $controller;
    public array $ctx;
    public string $route;
}
