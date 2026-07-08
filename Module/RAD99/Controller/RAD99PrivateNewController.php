<?php

declare(strict_types=1);

namespace Module\RAD99\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\RAD99\View\RAD99PrivateNewView;

class RAD99PrivateNewController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD99PrivateNewView::class,
        ];
    }
}
