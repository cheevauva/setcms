<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class OAuthUser extends OrdinaryEntity
{

    public string $refreshToken;
    public string $externalId;
    public string $clientId;
    public string $userId;

}
