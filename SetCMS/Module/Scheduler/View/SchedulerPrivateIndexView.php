<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\View;

use SetCMS\View\ViewTwig;

class SchedulerPrivateIndexView extends ViewTwig
{

    /**
     * @var \SetCMS\Module\Scheduler\Entity\SchedulerEntity[]
     */
    public array $schedulers = [];
}
