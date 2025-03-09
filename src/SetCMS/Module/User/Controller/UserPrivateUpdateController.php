<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\Attribute\Http\Parameter\Body;
use SetCMS\Module\User\Controller\UserPrivateUserScope;
use SetCMS\Module\User\DAO\UserRetrieveByIdDAO;
use SetCMS\Module\User\DAO\UserSaveDAO;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Attribute\ResponderPassProperty;
use SetCMS\Attribute\Http\RequestMethod;

#[RequestMethod('POST')]
class UserPrivateUpdateController extends UserPrivateController
{

    #[ResponderPassProperty('user')]
    private UserEntity $entity;

    #[Body('user')]
    public UserPrivateUserScope $user;

    #[\Override]
    protected function units(): array
    {
        return [
            UserRetrieveByIdDAO::class,
            UserSaveDAO::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRetrieveByIdDAO) {
            $this->entity = $object->user;
        }
    }

    #[\Override]
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
}
