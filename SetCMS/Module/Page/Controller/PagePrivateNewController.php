<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\Controller;
use SetCMS\Module\Page\View\PagePrivateNewView;

class PagePrivateNewController extends Controller
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePrivateNewView::class,
        ];
    }
}
