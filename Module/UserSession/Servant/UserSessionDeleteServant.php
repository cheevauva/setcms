<?php

declare(strict_types=1);

namespace Module\UserSession\Servant;

use SetCMS\UUID;
use Module\UserSession\UserSessionEntity;
use Module\UserSession\DAO\UserSessionRetrieveManyByCriteriaDAO;
use Module\UserSession\DAO\UserSessionSaveDAO;
use Module\UserSession\Exception\UserSessionNotFoundException;

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

        $retrieveById = UserSessionRetrieveManyByCriteriaDAO::new($this->container);
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
