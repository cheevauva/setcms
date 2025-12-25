<?php

declare(strict_types=1);

namespace Module\SchedulerJob\View;

use SetCMS\View\ViewJson;
use Module\SchedulerJob\Entity\SchedulerJobEntity;

class SchedulerJobPrivateUpdateView extends ViewJson
{

    public ?SchedulerJobEntity $schedulerJob = null;
}
