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
        $entity = $this->entity = new UserSessionEntity;
        $entity->id = $this->uuid('id');
        $entity->device = $this->string('device');
        $entity->userId = $this->uuid('user_id');
        $entity->dateExpiries = $this->dateTime('date_expiries');

        parent::run();
    }

}
