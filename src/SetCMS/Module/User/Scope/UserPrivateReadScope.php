<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\UUID;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Module\User\DAO\UserRetrieveByIdDAO;
use SetCMS\Module\User\Entity\UserEntity;

class UserPrivateReadScope extends UserPrivateScope
{

    private UserEntity $user;

    #[Attributes('id')]
    public UUID $id;

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRetrieveByIdDAO) {
            $this->user = $object->user;
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserRetrieveByIdDAO) {
            $object->id = $this->id;
            $object->throwExceptionIfNotFound = true;
        }
    }

    public function toArray(): array
    {
        return [
            'user' => $this->user ?? null,
        ];
    }

}
