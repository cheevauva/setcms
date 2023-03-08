<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession;

use SetCMS\Entity;
use SetCMS\UUID;

class UserSessionEntity extends Entity
{

    use \SetCMS\AsTrait;

    public string $device;
    public UUID $userId;
    public \DateTimeInterface $dateExpiries;

}
