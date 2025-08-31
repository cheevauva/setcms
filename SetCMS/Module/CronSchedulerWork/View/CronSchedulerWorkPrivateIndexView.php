<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\View;

use SetCMS\View\ViewTwig;

class CronSchedulerWorkPrivateIndexView extends ViewTwig
{

    /**
     * @var \SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity[]
     */
    public array $cronSchedulerWorks = [];
}
