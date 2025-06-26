<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\View;

use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;

class CronSchedulerPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?CronSchedulerEntity $cronScheduler = null;
}
