<?php

namespace SetCMS\Module\OAuth\OAuthClient;

class OAuthClientEntity extends \SetCMS\Entity
{

    public string $name;
    public UUID $clientId;
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
        
        $this->clientSecret = rand(9999, microtime(true));
    }

}
