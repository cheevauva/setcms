<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class OAuthClient extends OrdinaryEntity
{
    public string $name;
    public string $clientId;
    public string $clientSecret;
    public string $redirectURI;
    public string $loginURL;
    public string $autorizationCodeGrantTypeUrl = 'http://localhost/setcms4/public/index.php/OAuth/token';
    
    public static function generateSecret(): string
    {
        return md5(microtime());
    }
}
