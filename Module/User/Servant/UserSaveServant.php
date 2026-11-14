<?php

declare(strict_types=1);

namespace Module\User\Servant;

use Module\User\DAO\UserHasByIdDAO;
use Module\User\DAO\UserCreateDAO;
use Module\User\DAO\UserUpdateDAO;

class UserSaveServant extends \UUA\Servant
{

    use \SetCMS\Entity\Traits\EntityCallTrait;

    #[\Override]
    protected function run(): void
    {
        if (UserHasByIdDAO::call($this, $this->entity->id)->isExists) {
            UserCreateDAO::call($this, $this->entity);
        } else {
            UserUpdateDAO::call($this, $this->entity);
        }
    }
}
