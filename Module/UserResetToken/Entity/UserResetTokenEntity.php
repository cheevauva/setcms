<?php

declare(strict_types=1);

namespace Module\UserResetToken\Entity;

use SetCMS\Entity\Entity;
use SetCMS\UUID;

class UserResetTokenEntity extends Entity
{

    public \DateTimeImmutable $dateExpired;
    public UUID $userId;
    public string $token;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->token = (new UUID())->uuid;
    }
}
