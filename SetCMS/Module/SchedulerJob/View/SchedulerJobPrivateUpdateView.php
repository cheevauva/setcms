<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\View;

use SetCMS\View\ViewJson;
use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;

class SchedulerJobPrivateUpdateView extends ViewJson
{

    public ?SchedulerJobEntity $schedulerJob = null;
}
