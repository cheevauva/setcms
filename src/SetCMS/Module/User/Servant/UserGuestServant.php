<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Contract\Applicable;
use SetCMS\Controller\Event\FrontControllerResolveEvent;
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
        if ($object instanceof FrontControllerResolveEvent) {
            //
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof FrontControllerResolveEvent) {
            $object->withUser($this->user);
        }
    }

}
