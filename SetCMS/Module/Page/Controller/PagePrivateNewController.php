<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Page\View\PagePrivateNewView;

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
