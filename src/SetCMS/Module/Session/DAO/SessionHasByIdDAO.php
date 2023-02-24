<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\DAO;

use SetCMS\Entity\DAO\EntityHasByIdDAO;

class SessionHasByIdDAO extends EntityHasByIdDAO
{

    use SessionGenericDAO;
}
