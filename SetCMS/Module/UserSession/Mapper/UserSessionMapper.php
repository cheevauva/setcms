<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\UUID;

class UserSessionMapper extends EntityMapper
{

    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = UserSessionEntity::as($this->entity);

        $this->row['device'] = mb_substr($entity->device, 0, 50);
        $this->row['user_id'] = strval($entity->userId);
        $this->row['date_expiries'] = $entity->dateExpiries->format('Y-m-d H:i:s');
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = UserSessionEntity::as($this->entity);
        $entity->device = $this->row['device'] ?? throw new \RuntimeException('device не определён');
        $entity->userId = new UUID($this->row['user_id'] ?? throw new \RuntimeException('user_id не определён'));
        $entity->dateExpiries = new \DateTime($this->row['date_expiries'] ?? throw new \RuntimeException('date_expiries не определён'));
    }
}
