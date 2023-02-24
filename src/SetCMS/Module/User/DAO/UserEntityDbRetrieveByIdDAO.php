<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\UserEntity;

class UserEntityDbRetrieveByIdDAO extends \SetCMS\Entity\DAO\EntityRetrieveByIdDAO
{

    use UserEntityDbDAOTrait;

    public UserEntity $user;

    public function serve(): void
    {
        parent::serve();

        $this->user = $this->entity;
    }

}
