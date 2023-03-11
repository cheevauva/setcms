<?php

namespace SetCMS\Controller\Hook;

use SetCMS\Scope;
use SetCMS\Module\User\UserEntity;

class ScopeProtectionHook
{

    use \SetCMS\EventTrait;

    public Scope $scope;
    public ?UserEntity $user = null;


}
