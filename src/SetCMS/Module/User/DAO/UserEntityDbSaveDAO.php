<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

class UserEntityDbSaveDAO extends \SetCMS\Entity\DAO\EntityDbSaveDAO
{

    use UserEntityDbTrait;
    use \SetCMS\FactoryTrait;
}
