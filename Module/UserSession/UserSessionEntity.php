<?php

declare(strict_types=1);

namespace Module\UserSession;

use SetCMS\Entity\Entity;
use SetCMS\UUID;

class UserSessionEntity extends Entity
{

    public string $device;
    public UUID $userId;
    public \DateTimeInterface $dateExpiries;
}
