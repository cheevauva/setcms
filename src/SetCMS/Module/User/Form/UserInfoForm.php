<?php

namespace SetCMS\Module\User\Form;

use SetCMS\Core\Form;
use SetCMS\Module\User\Servant\UserEntityRetrieveByAccessTokenServant;
use SetCMS\TwigableInterface;

class UserInfoForm extends Form
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
