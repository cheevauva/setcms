<?php

namespace SetCMS\Module\User\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\View\UserPublicProfileView;

class UserPublicProfileController extends ControllerViaPSR7
{

    protected UserEntity $user;

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicProfileView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $this->user = $this->request->getAttribute('currentUser');
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserPublicProfileView) {
            $object->user = $this->user;
        }
    }
}
