<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp;

use SetCMS\Entity;
use SetCMS\UUID;

class OAuthAppEntity extends Entity
{

    public string $name;
    public string $clientId;
    public string $clientSecret;

    public function __construct()
    {
        parent::__construct();

        $this->clientId = strval(new UUID);
        $this->clientSecret = strval(new UUID);
    }

}
