<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

class UserEntityDbRetrieveByUsernameAndPasswordDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{
    public string $password;
    public string $username;

    use UserEntityDbTrait;
}
