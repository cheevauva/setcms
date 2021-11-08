<?php

namespace SetCMS\Module;

use SetCMS\Module\Module;
use SetCMS\Module\OAuth\OAuthClient;
use SetCMS\Module\Modules\Contract\ModuleResourceInterface;
use SetCMS\Module\Modules\Contract\ModuleAdminInterface;
use SetCMS\Module\OAuth\OAuthClientAdmin;
use SetCMS\Module\OAuth\OAuthClientResource;

class OAuthClients extends Module implements ModuleAdminInterface, ModuleResourceInterface
{

    public function getResource(): string
    {
        return 'oauthclient';
    }

    public function getEntityClassName(): string
    {
        return OAuthClient::class;
    }

    public function getAdminControllerClassName(): string
    {
        return OAuthClientAdmin::class;
    }

    public function getResourceControllerClassName(): string
    {
        return OAuthClientResource::class;
    }

}
