<?php

namespace SetCMS\Module\Users\UserEvent;

use SetCMS\Module\Users\User;

class RegistrationUserEvent
{

    public User $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

}
