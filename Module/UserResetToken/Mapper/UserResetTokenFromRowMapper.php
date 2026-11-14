<?php

declare(strict_types=1);

namespace Module\UserResetToken\Mapper;

use SetCMS\Entity\Mapper\EntityFromRowMapper;
use Module\UserResetToken\Entity\UserResetTokenEntity;

/**
 * @extends EntityFromRowMapper<UserResetTokenEntity>
 */
class UserResetTokenFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = $this->entity = new UserResetTokenEntity;
        $entity->dateExpired = $this->dateTime('date_expired');
        $entity->token = $this->string('token');
        $entity->userId = $this->uuid('user_id');

        parent::run();
    }
}
