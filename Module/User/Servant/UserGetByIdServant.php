<?php

declare(strict_types=1);

namespace Module\User\Servant;

use Module\User\Entity\UserEntity;
use Module\User\DAO\UserRetrieveManyByCriteriaDAO;

class UserGetByIdServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    public UserEntity $user;

    #[\Override]
    public function serve(): void
    {
        $userById = UserRetrieveManyByCriteriaDAO::new($this->container);
        $userById->allowEmptyResult = false;
        $userById->expectOne = true;
        $userById->id = $this->id;
        $userById->limit = 1;
        $userById->serve();

        $this->user = $userById->user;
    }
}
