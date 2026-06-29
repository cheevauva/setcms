<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use Module\User\Entity\UserEntity;
use Module\User\Exception\UserNotFoundKeyInRowException;
use Module\User\Enum\UserRoleEnum;

class UserFromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    public UserEntity $user;

    #[\Override]
    public function serve(): void
    {
        $this->user = new UserEntity;
        $this->user->username = $this->string('username');
        $this->user->password = $this->string('password');
        $this->user->email = $this->string('email');
        $this->user->role = UserRoleEnum::from($this->string('user_role'));
        $this->id($this->user);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): UserNotFoundKeyInRowException
    {
        return new UserNotFoundKeyInRowException($key);
    }
}
