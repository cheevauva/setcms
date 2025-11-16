<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use Module\SchedulerJob\Entity\SchedulerJobEntity;
use Module\SchedulerJob\Exception\SchedulerJobMapperException;
use Module\SchedulerJob\Enum\SchedulerJobStatusEnum;
use SetCMS\UUID;

class SchedulerJobMapper extends EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = SchedulerJobEntity::as($this->entity);

        $this->row['status'] = $entity->status->value;
        $this->row['scheduler_id'] = $entity->schedulerId->uuid;
        $this->row['date_start'] = $entity->dateStart?->format('Y-m-d H:i:s');
        $this->row['date_end'] = $entity->dateEnd?->format('Y-m-d H:i:s');
        $this->row['error'] = $entity->error;
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = SchedulerJobEntity::as($this->entity);
        $entity->status = SchedulerJobStatusEnum::from(strval($this->row['status'] ?? throw new SchedulerJobMapperException('row.status обязателен')));
        $entity->dateStart = !empty($this->row['date_start']) ? new \DateTimeImmutable($this->row['date_start']) : null;
        $entity->dateEnd = !empty($this->row['date_end']) ? new \DateTimeImmutable($this->row['date_end']) : null;
        $entity->error = !empty($this->row['error']) ? strval($this->row['date_end']) : null;
        $entity->schedulerId = new UUID($this->row['scheduler_id'] ?? throw new SchedulerJobMapperException('row.scheduler_id обязателен'));
    }
}
