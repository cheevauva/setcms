<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\DAO\UserSaveDAO;
use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\Event\UserRegistrationEvent;
use SetCMS\Module\User\Enum\UserRoleEnum;
use SetCMS\Module\User\Exception\UserAlreadyExistsException;

class UserRegistrationServant extends \UUA\Servant
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

        if (!empty($retrieveByUsername->first)) {
            throw new UserAlreadyExistsException;
        }

        $user = new UserEntity;
        $user->username = $this->username;
        $user->password = password_hash($this->password, PASSWORD_DEFAULT);
        $user->role = UserRoleEnum::USER;

        $saveUser = UserSaveDAO::new($this->container);
        $saveUser->user = $user;
        $saveUser->serve();

        $userRegistration = new UserRegistrationEvent($user);
        $userRegistration->dispatch($this->eventDispatcher());

        $this->user = $user;
    }
}
