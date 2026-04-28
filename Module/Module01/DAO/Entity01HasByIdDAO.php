<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

class Entity01HasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityHasByIdTrait;
    use \Module\Module01\Traits\Entity01DbalDAOTrait;
}
