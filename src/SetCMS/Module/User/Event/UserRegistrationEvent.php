<?php

namespace SetCMS\Module\User\Event;

use SetCMS\Module\User\Entity\UserEntity;

class UserRegistrationEvent
{

    use \SetCMS\Traits\AsTrait;
    use \SetCMS\Traits\EventTrait;

    public function __construct(public UserEntity $user)
    {
        
    }

}
