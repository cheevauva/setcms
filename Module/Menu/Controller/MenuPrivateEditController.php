<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use Module\Menu\View\MenuPrivateEditView;

class MenuPrivateEditController extends MenuPrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPrivateEditView::class,
        ];
    }
}
