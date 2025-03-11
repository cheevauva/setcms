<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\Exception\UserNotFoundException;
use SetCMS\Module\User\Exception\UserIncorrectPasswordException;
use SetCMS\Module\User\Entity\UserEntity;

class UserLoginServant extends \UUA\Servant
{

    public string $username;
    public string $password;
    public UserEntity $user;

    public function serve(): void
    {
        $retrieveByUsername = UserRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveByUsername->limit = 1;
        $retrieveByUsername->username = $this->username;
        $retrieveByUsername->serve();

        if (empty($retrieveByUsername->first)) {
            throw new UserNotFoundException;
        }

        $user = UserEntity::as($retrieveByUsername->first);

        if (!password_verify($this->password, $user->password)) {
            throw new UserIncorrectPasswordException;
        }

        $this->user = $user;
    }
}
