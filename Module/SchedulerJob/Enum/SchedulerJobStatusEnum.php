<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Enum;

enum SchedulerJobStatusEnum: string
{

    case _New = 'New';
    case InProgress = 'InProgress';
    case Error = 'error';
    case Done = 'done';
}
