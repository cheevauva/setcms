<?php

declare(strict_types=1);

namespace Module\User\Servant;

use Module\User\Entity\UserEntity;
use Module\User\DAO\UserCreateDAO;
use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use Module\User\Event\UserRegistrationEvent;
use Module\User\Exception\UserAlreadyExistsException;

class UserRegistrationServant extends \UUA\Servant
{

    public string $email;
    public string $password;
    public protected(set) UserEntity $user;

    public function serve(): void
    {
        $userByEmail = UserRetrieveManyByCriteriaDAO::new($this->container);
        $userByEmail->limit = 1;
        $userByEmail->allowEmptyResult = true;
        $userByEmail->expectOne = true;
        $userByEmail->email = $this->email;
        $userByEmail->serve();

        if ($userByEmail->userOrNull) {
            throw new UserAlreadyExistsException();
        }

        $user = $this->user = new UserEntity();
        $user->email = $this->email;
        $user->username = sprintf('user_%s_%s', date('YmdHis'), rand(100, 1000));
        $user->password = password_hash($this->password, PASSWORD_DEFAULT);
        $user->role = $user->role::USER;

        UserCreateDAO::call($this->container, $this->user);

        new UserRegistrationEvent($user)->dispatch($this->eventDispatcher());
    }
}
