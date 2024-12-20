<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Mapper;

use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\Enum\UserRoleEnum;

class UserMapper extends \SetCMS\Common\Mapper\EntityMapper
{

    use \SetCMS\Traits\FactoryTrait;

    protected function entity(): UserEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['username'] = $this->entity()->username;
        $this->row['password'] = $this->entity()->password;
        $this->row['role'] = $this->entity()->role->value;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->username = $this->row['username'];
        $this->entity()->password = $this->row['password'];
        $this->entity()->role = UserRoleEnum::from($this->row['role']);
    }

}
