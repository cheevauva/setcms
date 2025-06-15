<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\DAO;

use SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO;
use SetCMS\Module\UserSession\UserSessionEntity;

class UserSessionRetrieveByIdDAO extends EntityRetrieveManyByCriteriaDAO
{

    use UserSessionGenericDAO;

    public ?UserSessionEntity $session;

    public function serve(): void
    {
        parent::serve();

        $this->session = $this->first;
    }
}
