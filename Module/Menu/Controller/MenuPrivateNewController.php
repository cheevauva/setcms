<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use Module\Menu\View\MenuPrivateNewView;

class MenuPrivateNewController extends MenuPrivateEditController
{

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuPrivateNewView::class,
        ];
    }
}
