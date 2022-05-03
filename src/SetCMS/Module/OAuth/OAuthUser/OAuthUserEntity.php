<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthUser;

use SetCMS\GUID;

class OAuthUserEntity extends \SetCMS\Entity
{

    public string $refreshToken;
    public string $externalId;
    public string $clientId;
    public string $userId;

    public function __construct()
    {
        parent::__construct();

        $this->refreshToken = GUID::generate();
    }

}
