<?php

declare(strict_types=1);

namespace Module\User\Controller;

use SetCMS\UUID;
use Module\User\Servant\UserGetByIdServant;
use Module\User\Entity\UserEntity;
use Module\User\View\UserPrivateReadView;
use SetCMS\Mapper\MapperIdFromRequest;

class UserPrivateReadController extends UserPrivateController
{

    protected UserEntity $user;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MapperIdFromRequest::class,
            UserGetByIdServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPrivateReadView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserGetByIdServant) {
            $this->user = $object->user;
        }

        if ($object instanceof MapperIdFromRequest) {
            $this->id = $object->id;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserGetByIdServant) {
            $object->id = $this->id;
        }

        if ($object instanceof UserPrivateReadView) {
            $object->user = $this->user;
        }
    }
}
