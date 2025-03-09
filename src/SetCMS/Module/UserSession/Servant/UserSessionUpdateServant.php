<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Servant;


use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\UserSession\DAO\UserSessionHasByIdDAO;
use SetCMS\Module\UserSession\DAO\UserSessionSaveDAO;
use SetCMS\Module\UserSession\Exception\UserSessionNotFoundException;

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
