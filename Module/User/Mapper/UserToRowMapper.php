<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use Module\User\Entity\UserEntity;

class UserToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $user = UserEntity::as($this->entity);

        $this->row['username'] = $user->username;
        $this->row['password'] = $user->password;
        $this->row['user_role'] = $user->role->value;
        $this->row['email'] = $user->email;

        parent::run();
    }
}
