<?php

declare(strict_types=1);

namespace Module\UserResetToken\Mapper;

use Module\UserResetToken\Exception\UserResetTokenException;
use Module\UserResetToken\Entity\UserResetTokenEntity;
use SetCMS\UUID;

class UserResetTokenMapper extends \SetCMS\Common\Mapper\EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $userResetToken = UserResetTokenEntity::as($this->entity);

        $this->row['user_id'] = $userResetToken->userId->uuid;
        $this->row['date_expired'] = $userResetToken->dateExpired->format('Y-m-d H:i:s');
        $this->row['token'] = $userResetToken->token;
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $userResetToken = UserResetTokenEntity::as($this->entity);
        $userResetToken->dateExpired = new \DateTimeImmutable($this->row['date_expired'] ?? throw new UserResetTokenException('row.date_expired обязательный'));
        $userResetToken->token = strval($this->row['token'] ?? throw new UserResetTokenException('row.token обязательный'));
        $userResetToken->userId = new UUID($this->row['user_id'] ?? throw new UserResetTokenException('row.user_id обязательный'));
    }
}
