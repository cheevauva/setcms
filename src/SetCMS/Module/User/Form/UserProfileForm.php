<?php

namespace SetCMS\Module\User\Form;

use SetCMS\Core\Form;
use SetCMS\Module\User\Servant\UserEntityRetrieveByAccessTokenServant;
use SetCMS\TwigableInterface;
use SetCMS\Module\User\UserEntity;

class UserProfileForm extends Form implements TwigableInterface
{

    public string $token;
    private ?UserEntity $user = null;

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof UserEntityRetrieveByAccessTokenServant) {
            $object->accessToken = $this->token;
            $this->user = $object->user;
        }
    }


}
