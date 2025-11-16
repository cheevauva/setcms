<?php

declare(strict_types=1);

namespace Module\Scheduler\View;

use Module\Scheduler\Entity\SchedulerEntity;

class SchedulerPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?SchedulerEntity $scheduler = null;
}
