<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

class Entity01HasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityHasByIdDAOTrait;
    use \Module\Module01\Traits\Entity01DbalDAOTrait;
}
