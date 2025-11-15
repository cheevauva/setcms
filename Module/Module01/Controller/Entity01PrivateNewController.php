<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Module01\View\Entity01PrivateNewView;

class Entity01PrivateNewController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            Entity01PrivateNewView::class,
        ];
    }
}
