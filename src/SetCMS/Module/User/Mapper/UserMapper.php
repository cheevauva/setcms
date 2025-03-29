<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Mapper;

use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\Enum\UserRoleEnum;

class UserMapper extends \SetCMS\Common\Mapper\EntityMapper
{

    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = UserEntity::as($this->entity);

        $this->row['username'] = $entity->username;
        $this->row['password'] = $entity->password;
        $this->row['role'] = $entity->role->value;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = UserEntity::as($this->entity);
        $entity->username = strval($this->row['username'] ?? throw new \Exception('row.username not defined'));
        $entity->password = strval($this->row['password'] ?? throw new \Exception('row.password not defined'));
        $entity->role = UserRoleEnum::from(strval($this->row['role'] ?? throw new \Exception('row.role not defined')));
    }
}
