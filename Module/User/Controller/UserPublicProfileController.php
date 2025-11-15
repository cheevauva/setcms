<?php

namespace Module\User\Controller;

use SetCMS\ControllerViaPSR7;
use Module\User\View\UserPublicProfileView;

class UserPublicProfileController extends ControllerViaPSR7
{

    use \Module\User\Traits\UserCurrentTrait;

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
            $object->user = $this->currentUser();
        }
    }
}
