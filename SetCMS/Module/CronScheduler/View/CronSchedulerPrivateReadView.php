<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;

class CronSchedulerPrivateReadView extends ViewTwig
{

    public CronSchedulerEntity $cronScheduler;
}
