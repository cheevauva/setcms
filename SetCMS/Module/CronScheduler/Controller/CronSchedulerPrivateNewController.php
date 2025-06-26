<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronScheduler\View\CronSchedulerPrivateNewView;

class CronSchedulerPrivateNewController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CronSchedulerPrivateNewView::class,
        ];
    }
}
