<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use Module\User\Entity\UserEntity;
use Module\User\Enum\UserRoleEnum;
use SetCMS\Entity\Mapper\EntityFromRowMapper;

/**
 * @extends EntityFromRowMapper<UserEntity>
 */
class UserFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $user = $this->entity = new UserEntity;
        $user->username = $this->string('username');
        $user->password = $this->string('password');
        $user->email = $this->string('email');
        $user->role = UserRoleEnum::from($this->string('user_role'));

        parent::run();
    }
}
