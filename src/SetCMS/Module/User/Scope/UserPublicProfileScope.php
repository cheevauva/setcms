<?php

namespace SetCMS\Module\User\Scope;

use SetCMS\Scope;
use SetCMS\Module\User\UserEntity;

class UserPublicProfileScope extends Scope
{

    private ?UserEntity $user = null;

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserEntity) {
            $this->user = $object;
        }
    }

    public function toArray(): array
    {
        return [
            'user' => $this->user,
        ];
    }

}
