<?php

declare(strict_types=1);

namespace Module\Scheduler\VO;

class SchedulerJobVO extends \UUA\VO
{

    public string $name;
    public string $label;
    public string $className;
}
