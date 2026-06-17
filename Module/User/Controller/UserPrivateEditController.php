<?php

declare(strict_types=1);

namespace Module\User\Controller;

use Module\User\View\UserPrivateEditView;

class UserPrivateEditController extends UserPrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserPrivateEditView) {
            $object->user = $this->user;
        }
    }
}
