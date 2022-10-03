<?php

namespace SetCMS\Module\OAuth\OAuthToken;

use SetCMS\UUID;

class OAuthTokenEntity extends \SetCMS\Entity
{

    public string $refreshToken;
    public string $clientId;
    public string $userId;
    public \DateTime $dateExpiried;

    public function __construct()
    {
        parent::__construct();

        $this->refreshToken = strval(new UUID);
        $this->dateExpiried = new \DateTime('+1 hour');
    }

    public function regenerate(): void
    {
        $this->dateExpiried = new \DateTime('+1 hour');
        $this->dateModified = new \DateTime;
    }

}
