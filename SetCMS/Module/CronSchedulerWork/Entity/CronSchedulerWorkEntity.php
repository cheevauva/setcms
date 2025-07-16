<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Entity;

use SetCMS\UUID;
use SetCMS\Common\Entity\Entity;
use SetCMS\Module\CronSchedulerWork\Enum\CronSchedulerWorkStatusEnum;

class CronSchedulerWorkEntity extends Entity
{

    public UUID $cronSchedulerId;
    public CronSchedulerWorkStatusEnum $status = CronSchedulerWorkStatusEnum::_New;
    public ?\DateTimeImmutable $dateStart = null;
    public ?\DateTimeImmutable $dateEnd = null;
    public ?string $error = null;

    public function start(): void
    {
        $this->dateStart = new \DateTimeImmutable();
        $this->status = CronSchedulerWorkStatusEnum::InProgress;
    }

    public function end(): void
    {
        $this->dateEnd = new \DateTimeImmutable();
        $this->status = CronSchedulerWorkStatusEnum::Done;
    }

    public function error(string $error): void
    {
        $this->dateEnd = new \DateTimeImmutable();
        $this->status = CronSchedulerWorkStatusEnum::Error;
        $this->error = $error;
    }
}
