<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use SetCMS\DAO\EntityHasByIdDAO;

class UserSessionHasByIdDAO extends EntityHasByIdDAO
{

    use UserSessionGenericDAO;
}
