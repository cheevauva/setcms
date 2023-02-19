<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Module\User\Servant\UserLoginServant;
use SetCMS\Module\User\UserEntity;

class UserPublicDoLoginScope extends \SetCMS\Scope
{

    public string $username;
    public string $password;
    // public string $captcha;
    protected ?UserEntity $user = null;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserLoginServant) {
            $object->password = $this->password;
            $object->username = $this->username;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof UserLoginServant) {
            $this->user = $object->user;
        }
    }

}
