<?php

declare(strict_types=1);

namespace Module\User\Servant;

use Module\User\Entity\UserEntity;
use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Entity\Servant\EntityGetByIdServant;

/**
 * @extends EntityGetByIdServant<UserEntity>
 */
class UserGetByIdServant extends EntityGetByIdServant
{

    #[\Override]
    protected function manyByCriteria(): UserRetrieveManyByCriteriaDAO
    {
        return UserRetrieveManyByCriteriaDAO::new($this);
    }
}
