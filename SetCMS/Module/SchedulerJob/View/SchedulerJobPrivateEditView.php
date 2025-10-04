<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\View;

use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;

class SchedulerJobPrivateEditView extends SchedulerJobPrivateReadView
{

    public SchedulerJobEntity $SchedulerJob;
}
