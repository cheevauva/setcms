<?php

declare(strict_types=1);

namespace Module\SchedulerJob\View;

use SetCMS\View\ViewTwig;
use Module\SchedulerJob\Entity\SchedulerJobEntity;

class SchedulerJobPrivateReadView extends ViewTwig
{

    public SchedulerJobEntity $schedulerJob;
}
