<?php

declare(strict_types=1);

namespace Module\UserSession\Mapper;

use SetCMS\Entity\Mapper\EntityToRowMapper;
use Module\UserSession\UserSessionEntity;

class UserSessionToRowMapper extends EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = UserSessionEntity::as($this->entity);

        $this->row['device'] = mb_substr($entity->device, 0, 50);
        $this->row['user_id'] = strval($entity->userId);
        $this->row['date_expiries'] = $entity->dateExpiries->format('Y-m-d H:i:s');
        $this->row['date_created'] = $entity->dateCreated->format('Y-m-d H:i:s');

        parent::run();
    }
}
