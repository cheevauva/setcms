<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Mapper;

use SetCMS\Module\User\UserEntity;
use SetCMS\Module\User\UserRoleEnum;

class UserEntityDbMapper extends \SetCMS\Entity\Mapper\EntityMapper
{

    use \SetCMS\FactoryTrait;

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
