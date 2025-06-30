<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Enum;

enum CronSchedulerWorkStatusEnum: string
{

    case _New = 'New';
    case InProgress = 'InProgress';
    case Error = 'error';
    case Done = 'done';
}
