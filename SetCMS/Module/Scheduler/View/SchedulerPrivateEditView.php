<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\View;

use SetCMS\Module\Scheduler\Entity\SchedulerEntity;

class SchedulerPrivateEditView extends SchedulerPrivateReadView
{

    public SchedulerEntity $scheduler;
}
