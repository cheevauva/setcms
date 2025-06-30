<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;
use SetCMS\Module\CronSchedulerWork\Exception\CronSchedulerWorkMapperException;
use SetCMS\Module\CronSchedulerWork\Enum\CronSchedulerWorkStatusEnum;

class CronSchedulerWorkMapper extends EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = CronSchedulerWorkEntity::as($this->entity);

        $this->row['status'] = $entity->status->value;
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = CronSchedulerWorkEntity::as($this->entity);
        $entity->status = CronSchedulerWorkStatusEnum::from(strval($this->row['status'] ?? throw new CronSchedulerWorkMapperException('row.status обязателен')));
    }
}
