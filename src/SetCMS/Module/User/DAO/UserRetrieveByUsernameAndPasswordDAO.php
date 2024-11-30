<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\UserEntity;

class UserRetrieveByUsernameAndPasswordDAO extends \SetCMS\Common\DAO\Entity\EntityRetrieveByCriteriaDAO
{

    public string $password;
    public string $username;
    public ?UserEntity $user;

    use UserEntityDbDAOTrait;

    public function serve(): void
    {
        $this->criteria = [
            'username' => $this->username,
            'password' => $this->password,
        ];

        parent::serve();

        $this->user = $this->entity;
    }

}
