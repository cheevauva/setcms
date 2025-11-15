<?php

namespace Module\User\Event;

use Module\User\Entity\UserEntity;

class UserRegistrationEvent extends \UUA\Event
{

    public function __construct(public UserEntity $user)
    {
        
    }
}
