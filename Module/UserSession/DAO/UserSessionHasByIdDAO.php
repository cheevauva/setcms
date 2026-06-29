<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

class UserSessionHasByIdDAO extends \SetCMS\Entity\DAO\EntityHasByIdDAO
{

    use \Module\UserSession\Traits\UserSessionDbalDAOTrait;
}
