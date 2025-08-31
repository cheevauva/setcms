<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\View;

use SetCMS\View\ViewJson;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;

class CronSchedulerWorkPrivateUpdateView extends ViewJson
{

    public ?CronSchedulerWorkEntity $cronSchedulerWork = null;
}
