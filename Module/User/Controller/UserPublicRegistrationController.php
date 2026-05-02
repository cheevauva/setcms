<?php

namespace Module\User\Controller;

use Module\User\View\UserPublicRegistrationView;

class UserPublicRegistrationController extends \SetCMS\Controller\ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicRegistrationView::class
        ];
    }
}
