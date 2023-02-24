<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\ServantInterface;
use SetCMS\Contract\Applicable;
use SetCMS\Controller\Event\FrontControllerResolveEvent as Event;
use SetCMS\Module\User\UserEntity;

class UserGuestServant implements ServantInterface, Applicable
{

    private ?Event $event;
    public UserEntity $user;

    public function serve(): void
    {
        $this->user = new UserEntity;

        if ($this->event) {
            $this->event->withUser($this->user);
        }
    }

    public function apply(object $object): void
    {
        if ($object instanceof Event) {
            $this->event = $object;
        }
    }

}
