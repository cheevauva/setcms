<?php

declare(strict_types=1);

namespace Module\UserSession\Servant;

use Module\UserSession\UserSessionEntity;
use Module\UserSession\DAO\UserSessionHasByIdDAO;
use Module\UserSession\DAO\UserSessionSaveDAO;
use Module\UserSession\Exception\UserSessionAlreadyExistsException;

class UserSessionCreateServant extends \UUA\Servant
{

    public UserSessionEntity $session;

    public function serve(): void
    {
        $hasEntityById = UserSessionHasByIdDAO::new($this->container);
        $hasEntityById->id = $this->session->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new UserSessionAlreadyExistsException;
        }

        $saveEntity = UserSessionSaveDAO::new($this->container);
        $saveEntity->session = $this->session;
        $saveEntity->serve();
    }
}
