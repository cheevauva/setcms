<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Entity;

use SetCMS\UUID;
use SetCMS\Entity\Entity;
use Module\SchedulerJob\Enum\SchedulerJobStatusEnum;

class SchedulerJobEntity extends Entity
{

    public UUID $schedulerId;
    public SchedulerJobStatusEnum $status = SchedulerJobStatusEnum::_New;
    public ?\DateTimeImmutable $dateStart = null;
    public ?\DateTimeImmutable $dateEnd = null;
    public ?string $error = null;

    public function start(): void
    {
        $this->dateStart = new \DateTimeImmutable();
        $this->status = SchedulerJobStatusEnum::InProgress;
    }

    public function end(): void
    {
        $this->dateEnd = new \DateTimeImmutable();
        $this->status = SchedulerJobStatusEnum::Done;
    }

    public function error(string $error): void
    {
        $this->dateEnd = new \DateTimeImmutable();
        $this->status = SchedulerJobStatusEnum::Error;
        $this->error = $error;
    }
}
