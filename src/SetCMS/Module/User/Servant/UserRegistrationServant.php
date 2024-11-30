<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Module\User\UserEntity;
use SetCMS\Module\User\DAO\UserSaveDAO;
use SetCMS\Module\User\DAO\UserRetrieveByUsernameDAO;
use SetCMS\Module\User\Event\UserRegistrationEvent;
use SetCMS\Module\User\UserRoleEnum;
use SetCMS\Module\User\Exception\UserAlreadyExistsException;

class UserRegistrationServant implements \SetCMS\Contract\Servant
{

    use \SetCMS\Traits\DITrait;

    public string $username;
    public string $password;
    public ?UserEntity $user = null;

    public function serve(): void
    {
        $retrieveByUsername = UserRetrieveByUsernameDAO::make($this->factory());
        $retrieveByUsername->username = $this->username;
        $retrieveByUsername->serve();

        if ($retrieveByUsername->user) {
            throw new UserAlreadyExistsException;
        }

        $user = new UserEntity;
        $user->username = $this->username;
        $user->password = password_hash($this->password, PASSWORD_DEFAULT);
        $user->role = UserRoleEnum::USER;

        $saveUser = UserSaveDAO::make($this->factory());
        $saveUser->user = $user;
        $saveUser->serve();

        (new UserRegistrationEvent($user))();

        $this->user = $user;
    }

}
