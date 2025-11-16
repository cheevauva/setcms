<?php

declare(strict_types=1);

namespace Module\Scheduler\View;

use SetCMS\View\ViewTwig;

class SchedulerPrivateIndexView extends ViewTwig
{

    /**
     * @var \Module\Scheduler\Entity\SchedulerEntity[]
     */
    public array $schedulers = [];
}
