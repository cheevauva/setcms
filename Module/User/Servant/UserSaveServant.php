<?php

declare(strict_types=1);

namespace Module\User\Servant;

use Module\User\DAO\UserHasByIdDAO;
use Module\User\DAO\UserCreateDAO;
use Module\User\DAO\UserUpdateDAO;

class UserSaveServant extends \UUA\Servant
{

    use \Module\User\Traits\UserCallTrait;

    #[\Override]
    public function serve(): void
    {
        if (UserHasByIdDAO::call($this->container, $this->user->id)->isExists) {
            UserCreateDAO::call($this->container, $this->user);
        } else {
            UserUpdateDAO::call($this->container, $this->user);
        }
    }
}
