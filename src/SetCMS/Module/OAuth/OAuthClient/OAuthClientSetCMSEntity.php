<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient;

use SetCMS\UUID;

class OAuthClientSetCMSEntity extends OAuthClientEntity
{

    public function __construct()
    {
        parent::__construct();
        
        $this->clientId = strval(new UUID);
        $this->clientSecret = strval(new UUID);
    }

}
