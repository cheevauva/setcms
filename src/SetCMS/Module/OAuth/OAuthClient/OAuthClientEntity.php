<?php

namespace SetCMS\Module\OAuth\OAuthClient;

class OAuthClientEntity extends \SetCMS\Core\Entity
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

}
