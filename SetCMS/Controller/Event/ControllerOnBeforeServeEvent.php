<?php

namespace SetCMS\Controller\Event;

use SetCMS\Controller\ControllerViaPSR7;

class ControllerOnBeforeServeEvent extends \UUA\Event
{

    use \SetCMS\Traits\TraitsEvent;

    public ControllerViaPSR7 $controller;

    /**
     * @var array<string|mixed>
     */
    public array $ctx;
    public string $route;
}
