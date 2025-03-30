<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\UUID;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Module\User\DAO\UserRetrieveByIdDAO;
use SetCMS\Module\User\Entity\UserEntity;

class UserPrivateReadController extends UserPrivateController
{

    protected UserEntity $user;

    #[Attributes('id')]
    public UUID $id;

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRetrieveByIdDAO) {
            $this->user = $object->user;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserRetrieveByIdDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }
    }
}
