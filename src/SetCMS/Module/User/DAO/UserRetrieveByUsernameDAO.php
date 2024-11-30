<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\UserEntity;

class UserRetrieveByUsernameDAO extends \SetCMS\Common\DAO\Entity\EntityRetrieveByCriteriaDAO
{

    public ?UserEntity $user = null;
    public string $username;

    use UserEntityDbDAOTrait;

    public function serve(): void
    {
        $this->limit = 1;
        $this->criteria = [
            'username' => $this->username,
            'deleted' => 0,
        ];

        parent::serve();

        $this->user = $this->entity;
    }

}
