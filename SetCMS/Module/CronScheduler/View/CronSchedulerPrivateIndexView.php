<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\View;

use SetCMS\View\ViewTwig;

class CronSchedulerPrivateIndexView extends ViewTwig
{

    /**
     * @var \SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity[]
     */
    public array $cronSchedulers = [];
}
