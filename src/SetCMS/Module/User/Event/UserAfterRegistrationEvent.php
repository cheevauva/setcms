<?php

namespace SetCMS\Module\User\Event;

use SetCMS\Module\User\UserEntity;

class UserAfterRegistrationEvent
{

    use \SetCMS\EventTrait;

    public UserEntity $user;

    public function __construct(UserEntity $user)
    {
        $this->user = $user;
    }

}
