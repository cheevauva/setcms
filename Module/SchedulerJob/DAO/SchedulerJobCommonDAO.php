<?php

declare(strict_types=1);

namespace Module\SchedulerJob\DAO;

use Module\SchedulerJob\Mapper\SchedulerJobMapper;
use Module\SchedulerJob\SchedulerJobConstrants;

trait SchedulerJobCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function mapper(): SchedulerJobMapper
    {
        return SchedulerJobMapper::new($this->container);
    }

    protected function table(): string
    {
        return SchedulerJobConstrants::TABLE_NAME;
    }
}
