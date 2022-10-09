<?php

namespace SetCMS\Module\OAuth\OAuthToken;

use SetCMS\UUID;

class OAuthTokenEntity extends \SetCMS\Entity
{

    public string $token;
    public string $refreshToken;
    public UUID $clientId;
    public UUID $userId;
    public \DateTime $dateExpiried;

    public function __construct()
    {
        parent::__construct();

        $this->token = strval(new UUID);
        $this->refreshToken = strval(new UUID);
        $this->dateExpiried = new \DateTime('+1 hour');
    }

    public function regenerate(): void
    {
        $this->dateExpiried = new \DateTime('+1 hour');
        $this->dateModified = new \DateTime;
    }

}
