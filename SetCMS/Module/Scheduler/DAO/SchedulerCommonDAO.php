<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\DAO;

use SetCMS\Module\Scheduler\Mapper\SchedulerMapper;
use SetCMS\Module\Scheduler\SchedulerConstrants;

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
