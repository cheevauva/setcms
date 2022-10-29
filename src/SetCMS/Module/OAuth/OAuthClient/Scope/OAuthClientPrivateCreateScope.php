<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\Scope;

use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

class OAuthClientPrivateCreateScope extends \SetCMS\Entity\Scope\EntityCreateScope
{

    use OAuthClientPrivateSaveScopeTrait;

    protected function entity(): OAuthClientEntity
    {
        return new OAuthClientEntity;
    }

}
