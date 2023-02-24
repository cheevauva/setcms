<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Servant;

use SetCMS\ServantInterface;
use SetCMS\Module\Session\SessionEntity;
use SetCMS\Module\Session\DAO\SessionRetrieveByIdDAO;
use SetCMS\Module\Session\DAO\SessionSaveDAO;
use SetCMS\Module\Session\Exception\SessionNotFoundException;

class SessionDeleteServant implements ServantInterface
{

    use \SetCMS\DITrait;

    public ?SessionEntity $session = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $retrieveById = SessionRetrieveByIdDAO::make($this->factory());
        $retrieveById->id = $this->id ?? $this->session->id;
        $retrieveById->serve();

        if (!$retrieveById->entity) {
            throw new SessionNotFoundException;
        }

        $entity = $retrieveById->session;
        $entity->deleted = true;

        $save = SessionSaveDAO::make($this->factory());
        $save->entity = $entity;
        $save->serve();

        $this->entity = $entity;
    }

}
