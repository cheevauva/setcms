<?php

namespace Module\User\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\User\View\UserPublicProfileView;
use Module\User\Mapper\UserCurrentFromRequestMapper;
use Module\User\Entity\UserEntity;

class UserPublicProfileController extends ControllerViaPSR7
{

    protected UserEntity $user;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            UserCurrentFromRequestMapper::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicProfileView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserPublicProfileView) {
            $object->user = $this->user;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserCurrentFromRequestMapper) {
            $this->user = $object->user;
        }
    }
}
