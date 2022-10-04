<?php

namespace SetCMS\Module\OAuth\OAuthClient;

use SetCMS\UUID;

class OAuthClientEntity extends \SetCMS\Entity
{

    public string $name;
    public string $clientId;
    public string $clientSecret;
    public string $redirectURI;
    public string $loginUrl;
    public string $autorizationCodeUrl;
    public string $userInfoUrl;
    public string $userInfoParserRule;
    public bool $isAuthorizable = false;

    public function __construct()
    {
        parent::__construct();

        $this->clientId = strval(new UUID);
        $this->clientSecret = strval(new UUID);
    }

}
