<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Module\User\DAO\UserRetrieveByUsernameDAO;
use SetCMS\Module\User\Exception\UserNotFoundException;
use SetCMS\Module\User\Exception\UserIncorrectPasswordException;
use SetCMS\Module\User\UserEntity;

class UserLoginServant implements \SetCMS\Contract\Servant
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public string $username;
    public string $password;
    public UserEntity $user;

    public function serve(): void
    {
        $retrieveByUsername = UserRetrieveByUsernameDAO::make($this->factory());
        $retrieveByUsername->username = $this->username;
        $retrieveByUsername->serve();

        if (empty($retrieveByUsername->user)) {
            throw new UserNotFoundException;
        }

        $user = $retrieveByUsername->user;

        if (!password_verify($this->password, $user->password)) {
            throw new UserIncorrectPasswordException;
        }

        $this->user = $user;
    }

}
