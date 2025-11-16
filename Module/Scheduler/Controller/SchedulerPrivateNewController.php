<?php

declare(strict_types=1);

namespace Module\Scheduler\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Scheduler\View\SchedulerPrivateNewView;

class SchedulerPrivateNewController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            SchedulerPrivateNewView::class,
        ];
    }
}
