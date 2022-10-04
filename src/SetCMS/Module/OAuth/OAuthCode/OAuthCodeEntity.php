<?php

namespace SetCMS\Module\OAuth\OAuthCode;

use SetCMS\UUID;

class OAuthCodeEntity extends \SetCMS\Entity
{

    public string $code;
    public string $clientId;
    public string $userId;

    public function __construct()
    {
        parent::__construct();
        
        $this->code = strval(new UUID);
    }

}
