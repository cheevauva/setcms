<?php

namespace SetCMS\Module\User\Scope;

use SetCMS\Scope;
use SetCMS\Module\User\Servant\UserEntityRetrieveByOAuthAccessTokenServant;
use SetCMS\Contract\Twigable;
use SetCMS\Module\User\UserEntity;

class UserProfileScope extends Scope implements Twigable
{

    public string $token;
    private ?UserEntity $user = null;

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof UserEntityRetrieveByOAuthAccessTokenServant) {
            $object->accessToken = $this->token;
            $this->user = $object->user;
        }
    }

}
