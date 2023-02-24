<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Servant;

use SetCMS\ServantInterface;
use SetCMS\Module\Session\SessionEntity;
use SetCMS\Module\Session\DAO\SessionHasByIdDAO;
use SetCMS\Module\Session\DAO\SessionSaveDAO;
use SetCMS\Module\Session\Exception\SessionNotFoundException;

class SessionUpdateServant implements ServantInterface
{

    use \SetCMS\DITrait;

    public SessionEntity $session;

    public function serve(): void
    {
        $hasById = SessionHasByIdDAO::make($this->factory());
        $hasById->id = $this->session->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new SessionNotFoundException;
        }

        $saveEntity = SessionSaveDAO::make($this->factory());
        $saveEntity->session = $this->session;
        $saveEntity->serve();
    }

}
