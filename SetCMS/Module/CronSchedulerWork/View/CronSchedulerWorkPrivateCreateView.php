<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\View;

use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;

class CronSchedulerWorkPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?CronSchedulerWorkEntity $cronSchedulerWork = null;
}
