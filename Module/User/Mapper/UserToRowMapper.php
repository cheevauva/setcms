<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use Module\User\Entity\UserEntity;

class UserToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = UserEntity::as($this->entity);

        $this->row['username'] = $entity->username;
        $this->row['password'] = $entity->password;
        $this->row['user_role'] = $entity->role->value;
        $this->row['email'] = $entity->email;

        parent::run();
    }
}
