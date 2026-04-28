<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

class UserSessionDeleteByIdDAO extends \UUA\DAO
{

    use \Module\UserSession\Traits\UserSessionDbalDAOTrait;
    use \SetCMS\DAO\DAOEntityDeleteByIdTrait;
}
