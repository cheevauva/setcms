<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\UserSession\DAO\UserSessionHasByIdDAO;
use SetCMS\Module\UserSession\DAO\UserSessionSaveDAO;
use SetCMS\Module\UserSession\Exception\UserSessionAlreadyExistsException;

class UserSessionCreateServant implements ContractServant
{

    use \SetCMS\Traits\DITrait;

    public UserSessionEntity $session;

    public function serve(): void
    {
        $hasEntityById = UserSessionHasByIdDAO::make($this->factory());
        $hasEntityById->id = $this->session->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new UserSessionAlreadyExistsException;
        }

        $saveEntity = UserSessionSaveDAO::make($this->factory());
        $saveEntity->session = $this->session;
        $saveEntity->serve();
    }

}
