<?php

declare(strict_types=1);

namespace Module\Scheduler\View;

use SetCMS\View\ViewJson;
use Module\Scheduler\Entity\SchedulerEntity;

class SchedulerPrivateUpdateView extends ViewJson
{

    public ?SchedulerEntity $scheduler = null;
}
