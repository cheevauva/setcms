<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class OAuthClient extends OrdinaryEntity
{

    public string $module = 'OAuthClients';
    public string $name;
    public string $clientId;
    public string $clientSecret;
    public string $redirectURI;
    public string $loginUrl;
    public string $autorizationCodeUrl;
    public string $userInfoUrl;
    public string $userInfoParserRule;
    public bool $isAuthorizable = false;

    public static function generateSecret(): string
    {
        return md5(microtime());
    }

}
