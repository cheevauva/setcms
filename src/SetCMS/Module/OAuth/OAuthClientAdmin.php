<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\OAuth\OAuthClientService;

final class OAuthClientAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryControllerTrait;

    public function __construct(OAuthClientService $oauthClientService)
    {
        $this->service($oauthClientService);
    }

}
