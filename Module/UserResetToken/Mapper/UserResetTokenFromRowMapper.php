<?php

declare(strict_types=1);

namespace Module\UserResetToken\Mapper;

use Module\UserResetToken\Exception\UserResetTokenException;
use Module\UserResetToken\Entity\UserResetTokenEntity;

class UserResetTokenFromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityFromRowTrait;

    public UserResetTokenEntity $userResetToken;

    #[\Override]
    public function serve(): void
    {
        $this->userResetToken = new UserResetTokenEntity;
        $this->userResetToken->dateExpired = $this->dateTime('date_expired');
        $this->userResetToken->token = $this->string('token');
        $this->userResetToken->userId = $this->uuid('user_id');

        $this->mappingDefault($this->userResetToken);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        return new UserResetTokenException($key);
    }
}
