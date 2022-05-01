<?php

namespace SetCMS\Module\OAuth\OAuthToken;


class OAuthTokenEntity extends OrdinaryEntity
{

    public string $token;
    public string $tokenRefresh;
    public string $idClient;
    public string $idUser;
    public \DateTime $dateExpiried;

    public static function generateToken(): string
    {
        return md5(microtime());
    }
}
