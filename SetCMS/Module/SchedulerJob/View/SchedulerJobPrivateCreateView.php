<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\View;

use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;

class SchedulerJobPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?SchedulerJobEntity $schedulerJob = null;
}
