<?php

namespace SetCMS\Module\OAuth\OAuthToken;

use SetCMS\GUID;

class OAuthTokenEntity extends \SetCMS\Module\Ordinary\OrdinaryEntity
{

    public string $refrechToken;
    public string $clientId;
    public string $userId;
    public \DateTime $dateExpiried;

    public function __construct()
    {
        parent::__construct();

        $this->refrechToken = GUID::generate();
        $this->dateExpiried = new \DateTime('+1 hour');
    }

    public function regenerate(): void
    {
        $this->dateExpiried = new \DateTime('+1 hour');
        $this->dateModified = new \DateTime;
    }

}
