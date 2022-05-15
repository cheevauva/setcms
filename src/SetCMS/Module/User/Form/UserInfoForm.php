<?php

namespace SetCMS\Module\User\Form;

use SetCMS\Scope;
use SetCMS\Module\User\Servant\UserEntityRetrieveByAccessTokenServant;
use SetCMS\Contract\Twigable;

class UserInfoForm extends Scope
{

    public string $token;
    private $user;

    public function apply(object $object): void
    {
        if ($object instanceof UserEntityRetrieveByAccessTokenServant) {
            $object->accessToken = $this->token;
            $this->user = $object->user;
        }
    }

}
