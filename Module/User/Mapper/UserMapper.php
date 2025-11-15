<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use Module\User\Entity\UserEntity;
use Module\User\Enum\UserRoleEnum;
use Module\User\Exception\UserMapperException;

class UserMapper extends \SetCMS\Common\Mapper\EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = UserEntity::as($this->entity);

        $this->row['username'] = $entity->username;
        $this->row['password'] = $entity->password;
        $this->row['role'] = $entity->role->value;
        $this->row['email'] = $entity->email;
        $this->row['extra'] = json_encode(new \ArrayObject($this->extra2row()), JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return array<string|mixed>
     */
    protected function extra2row(): array
    {
        $user = UserEntity::as($this->entity);

        $extra = [];

        return $extra;
    }

    protected function extra4row(UserEntity $user): void
    {
        $extra = json_decode($this->row['extra'] ?? '{}');
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = UserEntity::as($this->entity);
        $entity->username = strval($this->row['username'] ?? throw new UserMapperException('row.username not defined'));
        $entity->password = strval($this->row['password'] ?? throw new UserMapperException('row.password not defined'));
        $entity->email = strval($this->row['email'] ?? throw new UserMapperException('row.email not defined'));
        $entity->role = UserRoleEnum::from(strval($this->row['role'] ?? throw new UserMapperException('row.role not defined')));
    }
}
