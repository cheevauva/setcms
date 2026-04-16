<?php

declare(strict_types=1);

namespace Module\UserSession;

use SetCMS\Entity\EntityBasic;
use SetCMS\UUID;

class UserSessionEntity extends EntityBasic
{

    public string $device;
    public UUID $userId;
    public \DateTimeInterface $dateExpiries;
}
