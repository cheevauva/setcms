<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\Scheduler\Entity\SchedulerEntity;

class SchedulerPrivateReadView extends ViewTwig
{

    public SchedulerEntity $scheduler;
}
