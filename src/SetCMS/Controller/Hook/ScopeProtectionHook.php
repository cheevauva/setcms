<?php

namespace SetCMS\Controller\Hook;

use SetCMS\Controller;
use SetCMS\Module\User\Entity\UserEntity;

class ScopeProtectionHook extends \UUA\Event
{

    use \SetCMS\Traits\EventTrait;

    public Controller $scope;
    public ?UserEntity $user = null;
}
