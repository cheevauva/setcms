<?php

declare(strict_types=1);

namespace Module\User\Servant;

use Module\User\Entity\UserEntity;
use Module\User\DAO\UserSaveDAO;
use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use Module\User\Event\UserRegistrationEvent;
use Module\User\Exception\UserAlreadyExistsException;

class UserRegistrationServant extends \UUA\Servant
{

    public string $email;
    public string $password;
    public UserEntity $user;

    public function serve(): void
    {
        $retrieveUser = UserRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveUser->limit = 1;
        $retrieveUser->email = $this->email;
        $retrieveUser->serve();

        if (!empty($retrieveUser->user)) {
            throw new UserAlreadyExistsException();
        }

        $user = new UserEntity();
        $user->email = $this->email;
        $user->username = sprintf('user_%s_%s', date('YmdHis'), rand(100, 1000));
        $user->password = password_hash($this->password, PASSWORD_DEFAULT);
        $user->role = $user->role::USER;

        $saveUser = UserSaveDAO::new($this->container);
        $saveUser->user = $user;
        $saveUser->serve();

        $userRegistration = new UserRegistrationEvent($user);
        $userRegistration->dispatch($this->eventDispatcher());

        $this->user = $user;
    }
}
