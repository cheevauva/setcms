<?php

namespace SetCMS\Module;

use SetCMS\Resource\ResourceModuleInterface;
use SetCMS\Module;
use SetCMS\Module\OAuth;

class OAuthClients extends Module implements ResourceModuleInterface
{

    public function getPrefix(): string
    {
        return OAuth::class . '\OAuthClient';
    }

    public function getResource(): string
    {
        return 'oauthclient';
    }

}
