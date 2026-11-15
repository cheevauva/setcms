<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\Controller\ControllerBlockViaPSR7;
use Module\Menu\View\MenuPublicMainSubView;

class MenuPublicMainSubController extends ControllerBlockViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPublicMainSubView::class,
        ];
    }
}
