<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Menu\View\MenuPublicMainView;

class MenuPublicMainController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPublicMainView::class,
        ];
    }
}
