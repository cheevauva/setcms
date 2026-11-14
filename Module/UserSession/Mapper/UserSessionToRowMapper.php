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
        $userSession = UserSessionEntity::as($this->entity);

        $this->row['device'] = mb_substr($userSession->device, 0, 50);
        $this->row['user_id'] = strval($userSession->userId);
        $this->row['date_expiries'] = $userSession->dateExpiries->format('Y-m-d H:i:s');
        $this->row['date_created'] = $userSession->dateCreated->format('Y-m-d H:i:s');

        parent::run();
    }
}
