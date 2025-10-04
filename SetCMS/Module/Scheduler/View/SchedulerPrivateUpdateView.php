<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\View;

use SetCMS\View\ViewJson;
use SetCMS\Module\Scheduler\Entity\SchedulerEntity;

class SchedulerPrivateUpdateView extends ViewJson
{

    public ?SchedulerEntity $scheduler = null;
}
