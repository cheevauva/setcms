<?php

declare(strict_types=1);

namespace Module\Scheduler\View;

use SetCMS\View\ViewTwig;
use Module\Scheduler\Entity\SchedulerEntity;

class SchedulerPrivateReadView extends ViewTwig
{

    public SchedulerEntity $scheduler;
}
