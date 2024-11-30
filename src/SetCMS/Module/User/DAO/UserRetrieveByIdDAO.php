<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\UserEntity;

class UserRetrieveByIdDAO extends \SetCMS\Common\DAO\Entity\EntityRetrieveByIdDAO
{

    use UserEntityDbDAOTrait;

    public UserEntity $user;

    public function serve(): void
    {
        parent::serve();

        $this->user = $this->entity;
    }

}
