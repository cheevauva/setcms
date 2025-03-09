<?php

namespace SetCMS\Module\User\Event;

use SetCMS\Module\User\Entity\UserEntity;

class UserRegistrationEvent extends \UUA\Event
{

    public function __construct(public UserEntity $user)
    {
        
    }

}
