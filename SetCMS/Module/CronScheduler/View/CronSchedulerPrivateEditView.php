<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\View;

use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;

class CronSchedulerPrivateEditView extends CronSchedulerPrivateReadView
{

    public CronSchedulerEntity $cronScheduler;
}
