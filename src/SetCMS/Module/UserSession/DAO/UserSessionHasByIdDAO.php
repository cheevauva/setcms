<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\DAO;

use SetCMS\Entity\DAO\EntityHasByIdDAO;

class UserSessionHasByIdDAO extends EntityHasByIdDAO
{

    use UserSessionGenericDAO;
}
