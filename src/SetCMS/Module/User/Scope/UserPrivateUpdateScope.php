<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Attribute\Http\Parameter\Body;
use SetCMS\Module\User\Scope\UserPrivateUserScope;
use SetCMS\Module\User\DAO\UserRetrieveByIdDAO;
use SetCMS\Module\User\DAO\UserSaveDAO;
use SetCMS\Module\User\Entity\UserEntity;

class UserPrivateUpdateScope extends UserPrivateScope
{

    private UserEntity $entity;

    #[Body('user')]
    public UserPrivateUserScope $user;

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRetrieveByIdDAO) {
            $this->entity = $object->user;
        }
    }

    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof UserRetrieveByIdDAO) {
            $object->throwExceptionIfNotFound = true;
            $object->id = $this->user->id;
        }


        if ($object instanceof UserSaveDAO) {
            $this->user->to($this->entity);
            $object->user = $this->entity;
        }
    }

    public function toArray(): array
    {
        return [
            'user' => $this->entity ?? null,
        ];
    }
}
