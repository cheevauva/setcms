<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Servant;

use SetCMS\ServantInterface;
use SetCMS\Module\Session\SessionEntity;
use SetCMS\Module\Session\DAO\SessionHasByIdDAO;
use SetCMS\Module\Session\DAO\SessionSaveDAO;
use SetCMS\Module\Session\Exception\SessionAlreadyExistsException;

class SessionCreateServant implements ServantInterface
{

    use \SetCMS\DITrait;

    public SessionEntity $session;

    public function serve(): void
    {
        $hasEntityById = SessionHasByIdDAO::make($this->factory());
        $hasEntityById->id = $this->session->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new SessionAlreadyExistsException;
        }

        $saveEntity = SessionSaveDAO::make($this->factory());
        $saveEntity->session = $this->session;
        $saveEntity->serve();
    }

}
