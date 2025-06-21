<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\Exception\UserNotFoundException;
use SetCMS\Module\User\Exception\UserIncorrectPasswordException;
use SetCMS\Module\User\Entity\UserEntity;

class UserLoginServant extends \UUA\Servant
{

    public string $email;
    public string $username;
    public string $password;
    public UserEntity $user;

    public function serve(): void
    {
        $retriveUser = UserRetrieveManyByCriteriaDAO::new($this->container);
        $retriveUser->limit = 1;
        $retriveUser->email = $this->email;
        $retriveUser->serve();

        if (empty($retriveUser->user)) {
            throw new UserNotFoundException();
        }

        $user = UserEntity::as($retriveUser->user);

        if (!password_verify($this->password, $user->password)) {
            throw new UserIncorrectPasswordException;
        }

        $this->user = $user;
    }
}
