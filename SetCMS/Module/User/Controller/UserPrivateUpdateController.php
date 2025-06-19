<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\DAO\UserSaveDAO;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\View\UserPrivateUpdateView;
use SetCMS\Module\User\Enum\UserRoleEnum;

class UserPrivateUpdateController extends UserPrivateController
{

    protected UserEntity $user;
    protected UserEntity $newUser;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            UserRetrieveManyByCriteriaDAO::class,
            UserSaveDAO::class,
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
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newUser = new UserEntity();
        $this->newUser->id = $validation->uuid('user.id')->notEmpty()->val();
        $this->newUser->role = UserRoleEnum::from($validation->string('user.role')->notEmpty()->val());
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

        if ($object instanceof UserSaveDAO) {
            $object->user = $this->user;
        }
    }
}
