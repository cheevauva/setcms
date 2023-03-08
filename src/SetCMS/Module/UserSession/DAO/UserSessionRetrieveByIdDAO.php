<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Module\UserSession\UserSessionEntity;

class UserSessionRetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use UserSessionGenericDAO;

    public ?UserSessionEntity $session;

    public function serve(): void
    {
        parent::serve();

        $this->session = $this->entity;
    }

}
