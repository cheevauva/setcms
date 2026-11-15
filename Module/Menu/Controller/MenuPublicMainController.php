<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\Controller\ControllerBlockViaPSR7;
use Module\Menu\View\MenuPublicMainView;

class MenuPublicMainController extends ControllerBlockViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPublicMainView::class,
        ];
    }
}
