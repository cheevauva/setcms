<?php

declare(strict_types=1);

namespace Module\Scheduler\View;

use Module\Scheduler\Entity\SchedulerEntity;

class SchedulerPrivateEditView extends SchedulerPrivateReadView
{

    public SchedulerEntity $scheduler;
}
