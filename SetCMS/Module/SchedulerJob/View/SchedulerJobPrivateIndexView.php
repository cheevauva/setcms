<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\View;

use SetCMS\View\ViewTwig;

class SchedulerJobPrivateIndexView extends ViewTwig
{

    /**
     * @var \SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity[]
     */
    public array $schedulerJobs = [];
}
