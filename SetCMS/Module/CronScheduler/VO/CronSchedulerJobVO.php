<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\VO;

class CronSchedulerJobVO extends \UUA\VO
{

    public string $name;
    public string $label;
    public string $className;
}
