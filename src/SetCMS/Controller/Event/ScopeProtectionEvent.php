<?php

namespace SetCMS\Controller\Event;

use SetCMS\Scope;
use SetCMS\Module\User\UserEntity;

class ScopeProtectionEvent
{

    use \SetCMS\EventTrait;

    public Scope $scope;
    public ?UserEntity $user = null;


}
