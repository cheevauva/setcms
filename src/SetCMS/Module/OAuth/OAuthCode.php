<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class OAuthCode extends OrdinaryEntity
{

    public string $code;
    public string $clientId;
    public string $userId;

    public static function generateCode(): string
    {
        return md5(microtime());
    }

}
