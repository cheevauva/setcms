<?php

namespace SetCMS\FrontController\Event;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Action;

class BeforeActionEvent
{

    use EventTrait;

    public Action $action;
    public ServerRequestInterface $request;

    public function __construct(Action $action, ServerRequestInterface $request)
    {
        $this->action = $action;
        $this->request = $request;
    }

}
