<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\UserSession\DAO\UserSessionRetrieveByIdDAO;
use SetCMS\Module\UserSession\DAO\UserSessionSaveDAO;
use SetCMS\Module\UserSession\Exception\UserSessionNotFoundException;

class UserSessionDeleteServant implements Servant
{

    use \SetCMS\Traits\DITrait;

    public ?UserSessionEntity $session = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $retrieveById = UserSessionRetrieveByIdDAO::make($this->factory());
        $retrieveById->id = $this->id ?? $this->session->id;
        $retrieveById->serve();

        if (!$retrieveById->entity) {
            throw new UserSessionNotFoundException;
        }

        $entity = $retrieveById->session;
        $entity->deleted = true;

        $save = UserSessionSaveDAO::make($this->factory());
        $save->entity = $entity;
        $save->serve();

        $this->entity = $entity;
    }

}
