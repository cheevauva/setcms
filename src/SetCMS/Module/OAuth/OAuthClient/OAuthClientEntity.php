<?php

namespace SetCMS\Module\OAuth\OAuthClient;

class OAuthClientEntity extends \SetCMS\Entity
{

    public string $name;
    public string $clientId;
    public string $clientSecret;
    public string $redirectURI;
    public string $loginUrl;
    public string $autorizationCodeUrl;
    public bool $isAuthorizable = false;

}
