<?php

declare(strict_types=1);

namespace Module\User\Controller;

use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use Module\User\DAO\UserUpdateDAO;
use Module\User\Entity\UserEntity;
use Module\User\View\UserPrivateUpdateView;
use Module\User\Mapper\UserFromRequestMapper;

class UserPrivateUpdateController extends UserPrivateController
{

    protected UserEntity $user;
    protected UserEntity $newUser;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            UserFromRequestMapper::class,
            UserRetrieveManyByCriteriaDAO::class,
            UserUpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPrivateUpdateView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRetrieveManyByCriteriaDAO) {
            $this->user = $object->user;
            $this->user->role = $this->newUser->role;
        }

        if ($object instanceof UserFromRequestMapper) {
            $this->newUser = $object->user;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserRetrieveManyByCriteriaDAO) {
            $object->id = $this->newUser->id;
        }

        if ($object instanceof UserPrivateUpdateView) {
            $object->user = $this->user;
        }

        if ($object instanceof UserUpdateDAO) {
            $object->user = $this->user;
        }
    }
}
