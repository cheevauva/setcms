<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\SchedulerJob\View\SchedulerJobPrivateNewView;

class SchedulerJobPrivateNewController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            SchedulerJobPrivateNewView::class,
        ];
    }
}
