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
        $userResetToken = $this->entity = new UserResetTokenEntity;
        $userResetToken->dateExpired = $this->dateTime('date_expired');
        $userResetToken->token = $this->string('token');
        $userResetToken->userId = $this->uuid('user_id');

        parent::run();
    }
}
