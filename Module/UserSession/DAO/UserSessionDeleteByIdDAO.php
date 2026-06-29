<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

class UserSessionDeleteByIdDAO extends \SetCMS\Entity\DAO\EntityDeleteByIdDAO
{

    use \Module\UserSession\Traits\UserSessionDbalDAOTrait;
}
