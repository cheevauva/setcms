<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Email\View\EmailPrivateNewView;

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
