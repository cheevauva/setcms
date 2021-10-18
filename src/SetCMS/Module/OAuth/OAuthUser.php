<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class OAuthUser extends OrdinaryEntity
{

    public string $refreshToken;
    public string $externalId;
    public int $clientId;
    public int $userId;

}
