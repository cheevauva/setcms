<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\DAO;

use SetCMS\Module\CronScheduler\Mapper\CronSchedulerMapper;
use SetCMS\Module\CronScheduler\CronSchedulerConstrants;

trait CronSchedulerCommonDAO
{

    use \SetCMS\Traits\DatabaseMainConnectionTrait;

    protected function mapper(): CronSchedulerMapper
    {
        return CronSchedulerMapper::new($this->container);
    }

    protected function table(): string
    {
        return CronSchedulerConstrants::TABLE_NAME;
    }
}
