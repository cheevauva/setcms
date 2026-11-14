<?php

declare(strict_types=1);

namespace Module\UserResetToken\Mapper;

use Module\UserResetToken\Entity\UserResetTokenEntity;

class UserResetTokenToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = UserResetTokenEntity::as($this->entity);

        $this->row['user_id'] = $entity->userId->uuid;
        $this->row['date_expired'] = $entity->dateExpired->format('Y-m-d H:i:s');
        $this->row['token'] = $entity->token;

        parent::run();
    }
}
