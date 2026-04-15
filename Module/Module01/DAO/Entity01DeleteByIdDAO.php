<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

class Entity01DeleteByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityDeleteByIdDAOTrait;
    use \Module\Module01\Traits\Entity01DbalDAOTrait;
}
