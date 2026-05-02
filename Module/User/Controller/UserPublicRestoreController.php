<?php

declare(strict_types=1);

namespace Module\User\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\User\View\UserPublicRestoreView;

class UserPublicRestoreController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicRestoreView::class,
        ];
    }
}
