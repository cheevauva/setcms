<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\FactoryInterface;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;
use SetCMS\Module\User\DAO\UserEntitySaveDAO;

class UserEntitySaveServant extends \SetCMS\Entity\Servant\EntitySaveServant
{

    public function __construct(FactoryInterface $factory)
    {
        $this->retrieveById = $factory->make(UserEntityDbRetrieveByIdDAO::class);
        $this->save = $factory->make(UserEntitySaveDAO::class);
    }

}
