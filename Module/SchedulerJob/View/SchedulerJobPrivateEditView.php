<?php

declare(strict_types=1);

namespace Module\SchedulerJob\View;

use Module\SchedulerJob\Entity\SchedulerJobEntity;

class SchedulerJobPrivateEditView extends SchedulerJobPrivateReadView
{

    public SchedulerJobEntity $SchedulerJob;
}
