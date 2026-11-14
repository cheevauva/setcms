<?php

declare(strict_types=1);

namespace Module\UserSession\Mapper;

use Module\UserSession\UserSessionEntity;
use SetCMS\Entity\Mapper\EntityFromRowMapper;

/**
 * @extends EntityFromRowMapper<UserSessionEntity>
 */
class UserSessionFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $userSession = $this->entity = new UserSessionEntity;
        $userSession->id = $this->uuid('id');
        $userSession->device = $this->string('device');
        $userSession->userId = $this->uuid('user_id');
        $userSession->dateExpiries = $this->dateTime('date_expiries');

        parent::run();
    }

}
