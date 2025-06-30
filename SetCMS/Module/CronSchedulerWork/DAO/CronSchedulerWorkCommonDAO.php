<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\DAO;

use SetCMS\Module\CronSchedulerWork\Mapper\CronSchedulerWorkMapper;
use SetCMS\Module\CronSchedulerWork\CronSchedulerWorkConstrants;

trait CronSchedulerWorkCommonDAO
{

    use \SetCMS\Traits\DatabaseMainConnectionTrait;

    protected function mapper(): CronSchedulerWorkMapper
    {
        return CronSchedulerWorkMapper::new($this->container);
    }

    protected function table(): string
    {
        return CronSchedulerWorkConstrants::TABLE_NAME;
    }
}
