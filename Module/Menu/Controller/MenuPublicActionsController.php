<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Menu\View\MenuPublicActionsView;

class MenuPublicActionsController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPublicActionsView::class,
        ];
    }
}
