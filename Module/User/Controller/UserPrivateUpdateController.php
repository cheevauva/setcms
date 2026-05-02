<?php

declare(strict_types=1);

namespace Module\User\Controller;

use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use Module\User\DAO\UserUpdateDAO;
use Module\User\Entity\UserEntity;
use Module\User\View\UserPrivateUpdateView;
use Module\User\Enum\UserRoleEnum;

class UserPrivateUpdateController extends UserPrivateController
{

    protected UserEntity $user;
    protected UserEntity $newUser;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
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
    protected function fromRequest(): void
    {
        $body = $this->validationBody();

        $this->newUser = new UserEntity();
        $this->newUser->id = $body->uuid('user.id')->notEmpty()->val();
        $this->newUser->role = UserRoleEnum::from($body->string('user.role')->notEmpty()->val());
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRetrieveManyByCriteriaDAO) {
            $this->user = UserEntity::as($object->user);
            $this->user->role = $this->newUser->role;
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
            $object->user = UserEntity::as($this->user);
        }

        if ($object instanceof UserUpdateDAO) {
            $object->user = $this->user;
        }
    }
}
