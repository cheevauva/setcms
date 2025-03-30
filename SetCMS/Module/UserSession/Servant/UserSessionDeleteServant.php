<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Servant;

use SetCMS\UUID;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\UserSession\DAO\UserSessionRetrieveByIdDAO;
use SetCMS\Module\UserSession\DAO\UserSessionSaveDAO;
use SetCMS\Module\UserSession\Exception\UserSessionNotFoundException;

class UserSessionDeleteServant extends \UUA\Servant
{

    public ?UserSessionEntity $session = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $sessionId = $this->id ?? ($this->session->id ?? null);

        if (empty($sessionId)) {
            throw new \RuntimeException('sessionId не определён');
        }

        $retrieveById = UserSessionRetrieveByIdDAO::new($this->container);
        $retrieveById->id = $sessionId;
        $retrieveById->serve();

        if (empty($retrieveById->session)) {
            throw new UserSessionNotFoundException;
        }

        $entity = $retrieveById->session;
        $entity->deleted = true;

        $save = UserSessionSaveDAO::new($this->container);
        $save->session = $entity;
        $save->serve();

        $this->session = $entity;
    }
}
