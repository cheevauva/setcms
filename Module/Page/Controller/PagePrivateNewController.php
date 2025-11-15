<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Page\View\PagePrivateNewView;

class PagePrivateNewController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePrivateNewView::class,
        ];
    }
}
