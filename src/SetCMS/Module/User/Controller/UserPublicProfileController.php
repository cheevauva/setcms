<?php

namespace SetCMS\Module\User\Controller;

use SetCMS\Controller;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\View\UserPublicProfileView;
use SetCMS\Attribute\Http\RequestMethod;

#[RequestMethod('GET')]
class UserPublicProfileController extends Controller
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
    protected function mapper(): void
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
