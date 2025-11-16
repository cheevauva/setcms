<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\SchedulerJob\View\SchedulerJobPrivateNewView;

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
