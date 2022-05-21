<?php

namespace SetCMS\Controller\Event;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Scope;

class ScopeProtectionEvent
{

    use \SetCMS\EventTrait;

    public Scope $scope;
    public ServerRequestInterface $request;

    public function __construct(Scope $scope, ServerRequestInterface $request)
    {
        $this->scope = $scope;
        $this->request = $request;
    }

}
