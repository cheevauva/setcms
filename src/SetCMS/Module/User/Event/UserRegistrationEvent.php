<?php

namespace SetCMS\Module\User\Event;

use SetCMS\Module\User\UserEntity;

class UserRegistrationEvent
{

    use \SetCMS\AsTrait;
    use \SetCMS\EventTrait;

    public function __construct(public UserEntity $user)
    {
    }

}
