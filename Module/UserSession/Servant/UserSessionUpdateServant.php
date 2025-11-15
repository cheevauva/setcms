<?php

declare(strict_types=1);

namespace Module\UserSession\Servant;

use Module\UserSession\UserSessionEntity;
use Module\UserSession\DAO\UserSessionHasByIdDAO;
use Module\UserSession\DAO\UserSessionSaveDAO;
use Module\UserSession\Exception\UserSessionNotFoundException;

class UserSessionUpdateServant extends \UUA\Servant
{

    public UserSessionEntity $session;

    public function serve(): void
    {
        $hasById = UserSessionHasByIdDAO::new($this->container);
        $hasById->id = $this->session->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new UserSessionNotFoundException;
        }

        $saveEntity = UserSessionSaveDAO::new($this->container);
        $saveEntity->session = $this->session;
        $saveEntity->serve();
    }
}
