<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Entity;

use SetCMS\Common\Entity\Entity;

class CronSchedulerEntity extends Entity
{

    public string $job;
    public string $cronExpression;
    public ?\DateTimeImmutable $dateStart = null;
    public ?\DateTimeImmutable $dateEnd = null;
    public bool $isActive = true;
    public bool $isSafeRun = true;
}
