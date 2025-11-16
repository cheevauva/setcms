<?php

declare(strict_types=1);

namespace Module\SchedulerJob\View;

use SetCMS\View\ViewTwig;

class SchedulerJobPrivateIndexView extends ViewTwig
{

    /**
     * @var \Module\SchedulerJob\Entity\SchedulerJobEntity[]
     */
    public array $schedulerJobs = [];
}
