<?php

declare(strict_types=1);

namespace Module\Email\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Email\View\EmailPrivateNewView;

class EmailPrivateNewController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            EmailPrivateNewView::class,
        ];
    }
}
