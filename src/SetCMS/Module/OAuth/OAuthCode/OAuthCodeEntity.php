<?php

namespace SetCMS\Module\OAuth\OAuthCode;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class OAuthCodeEntity extends OrdinaryEntity
{

    public string $code;
    public string $clientId;
    public string $userId;

    public function __construct()
    {
        $this->code = md5(microtime());
    }

}
