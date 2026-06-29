<?php

declare(strict_types=1);

namespace Module\UserResetToken\Mapper;

use Module\UserResetToken\Exception\UserResetTokenMapperNotFoundKeyInRowException;
use Module\UserResetToken\Entity\UserResetTokenEntity;

class UserResetTokenFromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    public UserResetTokenEntity $userResetToken;

    #[\Override]
    public function serve(): void
    {
        $this->userResetToken = new UserResetTokenEntity;
        $this->userResetToken->id = $this->uuid('id');
        $this->userResetToken->dateExpired = $this->dateTime('date_expired');
        $this->userResetToken->token = $this->string('token');
        $this->userResetToken->userId = $this->uuid('user_id');
        $this->id($this->userResetToken);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): UserResetTokenMapperNotFoundKeyInRowException
    {
        return new UserResetTokenMapperNotFoundKeyInRowException($key);
    }
}
