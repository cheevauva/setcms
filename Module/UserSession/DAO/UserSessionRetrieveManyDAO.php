<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use SetCMS\DAO\EntityRetrieveManyByCriteriaDAO;
use Module\UserSession\Exception\UserSessionNotFoundException;

class UserSessionRetrieveManyDAO extends EntityRetrieveManyByCriteriaDAO
{

    use UserSessionGenericDAO;

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new UserSessionNotFoundException();
    }
}
