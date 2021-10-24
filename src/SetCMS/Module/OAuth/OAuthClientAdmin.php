<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\OAuth\OAuthClientService;
use SetCMS\Module\Ordinary\OrdinaryController;

final class OAuthClientAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryCRUD;

    public function __construct(OAuthClientService $oauthClientService, OrdinaryController $ordinary)
    {
        $this->ordinary(clone $ordinary)->service($oauthClientService);
    }

}
