<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;

class CronSchedulerWorkPrivateReadView extends ViewTwig
{

    public CronSchedulerWorkEntity $cronSchedulerWork;
}
