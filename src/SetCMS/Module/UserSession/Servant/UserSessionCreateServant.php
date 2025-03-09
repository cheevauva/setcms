<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Servant;


use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\UserSession\DAO\UserSessionHasByIdDAO;
use SetCMS\Module\UserSession\DAO\UserSessionSaveDAO;
use SetCMS\Module\UserSession\Exception\UserSessionAlreadyExistsException;

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
