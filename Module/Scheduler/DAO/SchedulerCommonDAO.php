<?php

declare(strict_types=1);

namespace Module\Scheduler\DAO;

use Module\Scheduler\Mapper\SchedulerMapper;
use Module\Scheduler\SchedulerConstrants;

trait SchedulerCommonDAO
{

    use \SetCMS\Traits\DatabaseMainTrait;

    protected function mapper(): SchedulerMapper
    {
        return SchedulerMapper::new($this->container);
    }

    protected function table(): string
    {
        return SchedulerConstrants::TABLE_NAME;
    }
}
