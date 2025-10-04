<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\View;

use SetCMS\Module\Scheduler\Entity\SchedulerEntity;

class SchedulerPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?SchedulerEntity $scheduler = null;
}
