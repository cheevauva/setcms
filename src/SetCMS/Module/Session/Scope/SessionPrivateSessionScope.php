<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Scope;

use SetCMS\Module\Session\SessionEntity;
use SetCMS\UUID;

class SessionPrivateSessionScope extends SessionPrivateScope
{

    public UUID $id;
    public string $device;
    public string $userId;
    public string $dateExpires;

    public function satisfy(): \Iterator
    {
        parent::satisfy();

        if (0) {
            yield ['', ''];
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SessionEntity) {
            $object->id = $this->id;
            $object->device = $this->device;
            $object->userId = $this->userId;
            $object->dateExpiries = $this->dateExpires;
        }
    }

}
