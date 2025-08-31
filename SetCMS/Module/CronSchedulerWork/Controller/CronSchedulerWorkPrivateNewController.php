<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronSchedulerWork\View\CronSchedulerWorkPrivateNewView;

class CronSchedulerWorkPrivateNewController extends ControllerViaPSR7
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CronSchedulerWorkPrivateNewView::class,
        ];
    }
}
