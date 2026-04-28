<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

class UserSessionHasByIdDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityHasByIdTrait;
    use \Module\UserSession\Traits\UserSessionDbalDAOTrait;
}
