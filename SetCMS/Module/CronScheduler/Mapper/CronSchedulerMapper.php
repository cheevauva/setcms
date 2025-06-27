<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\CronScheduler\Entity\CronSchedulerEntity;
use SetCMS\Module\CronScheduler\Exception\CronSchedulerMapperException;

class CronSchedulerMapper extends EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = CronSchedulerEntity::as($this->entity);

        $this->row['job'] = $entity->job;
        $this->row['cron_expression'] = $entity->cronExpression;
        $this->row['is_active'] = intval($entity->isActive);
        $this->row['is_safe_run'] = intval($entity->isSafeRun);
        $this->row['date_start'] = $entity->dateStart?->format('Y-m-d H:i:s');
        $this->row['date_end'] = $entity->dateEnd?->format('Y-m-d H:i:s');
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();
        
        $entity = CronSchedulerEntity::as($this->entity);
        $entity->job = strval($this->row['job'] ?? throw new CronSchedulerMapperException('row.job обязателен'));
        $entity->cronExpression = strval($this->row['cron_expression'] ?? throw new CronSchedulerMapperException('row.cron_expression обязателен'));
        $entity->isActive = boolval($this->row['is_active'] ?? throw new CronSchedulerMapperException('row.is_active обязателен'));
        $entity->isSafeRun = boolval($this->row['is_safe_run'] ?? throw new CronSchedulerMapperException('row.is_safe_run обязателен'));
        $entity->dateStart = !empty($this->row['date_start']) ? new \DateTimeImmutable($this->row['date_start']) : null;
        $entity->dateEnd = !empty($this->row['date_end']) ? new \DateTimeImmutable($this->row['date_end']) : null;
    }
}
