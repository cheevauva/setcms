<?php

declare(strict_types=1);

namespace Module\Migration\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Migration\View\MigrationPublicUpView;

class MigrationPublicUpController extends ControllerViaPSR7
{

    public bool $hasACLCheck = false;

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MigrationPublicUpView::class,
        ];
    }
}
