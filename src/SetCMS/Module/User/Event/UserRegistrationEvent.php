<?php

namespace SetCMS\Module\User\Event;

use SetCMS\Module\User\UserEntity;

class UserRegistrationEvent
{

    use \SetCMS\EventTrait;

    public UserEntity $user;

}
