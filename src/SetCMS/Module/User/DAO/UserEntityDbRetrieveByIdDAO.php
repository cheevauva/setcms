<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Core\Entity\DAO\EntityDbRetrieveByCriteriaDAO;

class UserEntityDbRetrieveByIdDAO extends EntityDbRetrieveByCriteriaDAO
{

    use UserEntityDbTrait;
}
