<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Module\Menu\View\MenuPrivateNewView;

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
