<?php

declare(strict_types=1);

namespace Module\SchedulerJob\View;

use Module\SchedulerJob\Entity\SchedulerJobEntity;

class SchedulerJobPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?SchedulerJobEntity $schedulerJob = null;
}
