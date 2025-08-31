<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\View;

use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;

class CronSchedulerWorkPrivateEditView extends CronSchedulerWorkPrivateReadView
{

    public CronSchedulerWorkEntity $cronSchedulerWork;
}
