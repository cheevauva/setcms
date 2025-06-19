<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\DAO;

use SetCMS\Common\DAO\EntityHasByIdDAO;

class UserSessionHasByIdDAO extends EntityHasByIdDAO
{

    use UserSessionGenericDAO;
}
