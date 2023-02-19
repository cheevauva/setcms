<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Module\User\DAO\UserEntityRetrieveByUsernameDAO;
use SetCMS\Module\User\Exception\UserNotFoundException;
use SetCMS\Module\User\Exception\UserIncorrectPasswordException;
use SetCMS\Module\User\UserEntity;

class UserLoginServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public string $username;
    public string $password;
    public UserEntity $user;

    public function serve(): void
    {
        $retrieveByUsername = UserEntityRetrieveByUsernameDAO::make($this->factory());
        $retrieveByUsername->username = $this->username;
        $retrieveByUsername->serve();

        if (empty($retrieveByUsername->user)) {
            throw UserNotFoundException::withoutUser();
        }
        
        $user = $retrieveByUsername->user;

        if (!password_verify($this->password, $user->password)) {
            throw UserIncorrectPasswordException::withUser($user);
        }

        $this->user = $user;
    }

}
