<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\View;

use SetCMS\View\ViewJson;
use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;

class CronSchedulerPrivateUpdateView extends ViewJson
{

    public ?CronSchedulerEntity $cronScheduler = null;
}
