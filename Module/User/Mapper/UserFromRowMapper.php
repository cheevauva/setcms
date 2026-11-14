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
        $entity = $this->entity = new UserEntity;
        $entity->username = $this->string('username');
        $entity->password = $this->string('password');
        $entity->email = $this->string('email');
        $entity->role = UserRoleEnum::from($this->string('user_role'));

        parent::run();
    }
}
