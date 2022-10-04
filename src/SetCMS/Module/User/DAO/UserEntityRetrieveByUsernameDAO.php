<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

class UserEntityRetrieveByUsernameDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{

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
    }

}
