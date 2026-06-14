<?php

namespace SetCMS\Controller\Event;

use SetCMS\Controller\ControllerViaPSR7;

class ControllerOnBeforeServeEvent extends \UUA\Event
{

    use \SetCMS\Traits\TraitsEvent;

    public function __construct(public ControllerViaPSR7 $controller)
    {
        
    }
}
