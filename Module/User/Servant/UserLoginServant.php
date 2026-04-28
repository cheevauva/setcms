<?php

declare(strict_types=1);

namespace Module\User\Servant;

use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use Module\User\Exception\UserIncorrectPasswordException;
use Module\User\Entity\UserEntity;

class UserLoginServant extends \UUA\Servant
{

    public string $email;
    public string $password;
    public protected(set) UserEntity $user;

    #[\Override]
    public function serve(): void
    {
        $retriveUser = UserRetrieveManyByCriteriaDAO::new($this->container);
        $retriveUser->limit = 1;
        $retriveUser->email = $this->email;
        $retriveUser->expectOne = true;
        $retriveUser->allowEmptyResult = false;
        $retriveUser->serve();

        $this->user = $retriveUser->user;

        if (!password_verify($this->password, $this->user->password)) {
            throw new UserIncorrectPasswordException;
        }
    }
}
