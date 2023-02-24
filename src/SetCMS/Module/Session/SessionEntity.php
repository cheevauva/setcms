<?php

declare(strict_types=1);

namespace SetCMS\Module\Session;

use SetCMS\Entity;
use SetCMS\UUID;

class SessionEntity extends Entity
{

    use \SetCMS\AsTrait;

    public string $device;
    public UUID $userId;
    public \DateTimeInterface $dateExpiries;

}
