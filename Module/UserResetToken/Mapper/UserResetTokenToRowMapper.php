<?php

declare(strict_types=1);

namespace Module\UserResetToken\Mapper;

use Module\UserResetToken\Entity\UserResetTokenEntity;

class UserResetTokenToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $userResetToken = UserResetTokenEntity::as($this->entity);

        $this->row['user_id'] = $userResetToken->userId->uuid;
        $this->row['date_expired'] = $userResetToken->dateExpired->format('Y-m-d H:i:s');
        $this->row['token'] = $userResetToken->token;

        parent::run();
    }
}
