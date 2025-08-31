<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;
use SetCMS\Module\CronSchedulerWork\Exception\CronSchedulerWorkMapperException;
use SetCMS\Module\CronSchedulerWork\Enum\CronSchedulerWorkStatusEnum;
use SetCMS\UUID;

class CronSchedulerWorkMapper extends EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = CronSchedulerWorkEntity::as($this->entity);

        $this->row['status'] = $entity->status->value;
        $this->row['cronscheduler_id'] = $entity->cronSchedulerId->uuid;
        $this->row['date_start'] = $entity->dateStart?->format('Y-m-d H:i:s');
        $this->row['date_end'] = $entity->dateEnd?->format('Y-m-d H:i:s');
        $this->row['error'] = $entity->error;
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = CronSchedulerWorkEntity::as($this->entity);
        $entity->status = CronSchedulerWorkStatusEnum::from(strval($this->row['status'] ?? throw new CronSchedulerWorkMapperException('row.status обязателен')));
        $entity->dateStart = !empty($this->row['date_start']) ? new \DateTimeImmutable($this->row['date_start']) : null;
        $entity->dateEnd = !empty($this->row['date_end']) ? new \DateTimeImmutable($this->row['date_end']) : null;
        $entity->error = !empty($this->row['error']) ? strval($this->row['date_end']) : null;
        $entity->cronSchedulerId = new UUID($this->row['cronscheduler_id'] ?? throw new CronSchedulerWorkMapperException('row.cronscheduler_id обязателен'));
    }
}
