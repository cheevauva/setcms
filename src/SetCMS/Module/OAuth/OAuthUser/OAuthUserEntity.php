<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthUser;

use SetCMS\UUID;

class OAuthUserEntity extends \SetCMS\Entity
{

    public string $refreshToken;
    public string $externalId;
    public UUID $clientId;
    public UUID $userId;

    public function __construct()
    {
        parent::__construct();

        $this->refreshToken = strval(new UUID);
    }

}
