<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

class UserEntityDbRetrieveByUsernameDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{

    public string $username;

    use UserEntityDbTrait;
    use \SetCMS\FactoryTrait;
    
    public function serve(): void
    {
        $this->criteria = [
            'username' => $this->username,
            'deleted' => 0,
        ];
        
        parent::serve();
    }
}
