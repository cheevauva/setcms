<?php

namespace SetCMS\Module\User\Scope;

use SetCMS\Scope;
use SetCMS\Module\User\Servant\UserEntityRetrieveByOAuthAccessTokenServant;

class UserInfoScope extends Scope
{

    public string $token;
    private $user;

    public function apply(object $object): void
    {
        if ($object instanceof UserEntityRetrieveByOAuthAccessTokenServant) {
            $object->accessToken = $this->token;
            $this->user = $object->user;
        }
    }

}
