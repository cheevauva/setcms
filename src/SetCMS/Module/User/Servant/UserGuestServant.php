<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Contract\Applicable;
use SetCMS\Controller\Hook\FrontControllerResolveHook;
use SetCMS\Module\User\UserEntity;

class UserGuestServant implements Servant, Applicable
{

    public UserEntity $user;

    public function serve(): void
    {
        $this->user = new UserEntity;
    }

    public function from(object $object): void
    {
        if ($object instanceof FrontControllerResolveHook) {
            //
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof FrontControllerResolveHook) {
            $object->withUser($this->user);
        }
    }

}
