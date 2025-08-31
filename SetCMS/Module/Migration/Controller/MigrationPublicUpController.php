<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Migration\View\MigrationPublicUpView;

class MigrationPublicUpController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MigrationPublicUpView::class,
        ];
    }
}
