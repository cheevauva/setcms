<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\UserEntity;

class UserEntityDbMapper extends \SetCMS\Entity\EntityDbMapper
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
        $this->row['role'] = $this->entity()->role;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->username = $this->row['username'];
        $this->entity()->password = $this->row['password'];
        $this->entity()->role = $this->row['role'];
    }

}
