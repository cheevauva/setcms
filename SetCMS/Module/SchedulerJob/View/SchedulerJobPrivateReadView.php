<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;

class SchedulerJobPrivateReadView extends ViewTwig
{

    public SchedulerJobEntity $schedulerJob;
}
