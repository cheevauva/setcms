<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp\Scope;

use SetCMS\Module\OAuth\OAuthApp\OAuthAppEntity;

class OAuthAppPrivateCreateScope extends \SetCMS\Entity\Scope\EntityCreateScope
{

    use OAuthAppPrivateEntityScopeTrait;

    protected function entity(): OAuthAppEntity
    {
        return new OAuthAppEntity;
    }

}
