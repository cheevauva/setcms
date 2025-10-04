<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Scheduler\View\SchedulerPrivateNewView;

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
