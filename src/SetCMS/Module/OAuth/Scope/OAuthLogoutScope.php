<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Scope;

use SetCMS\Module\OAuth\Servant\OAuthLogoutByTokenServant;

class OAuthLogoutScope extends \SetCMS\Scope
{

    public string $token;

    public function to(object $object): void
    {
        parent::from($object);

        if ($object instanceof OAuthLogoutByTokenServant) {
            $object->token = $this->token;
        }
    }

}
