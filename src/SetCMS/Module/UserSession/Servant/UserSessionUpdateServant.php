<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\UserSession\DAO\UserSessionHasByIdDAO;
use SetCMS\Module\UserSession\DAO\UserSessionSaveDAO;
use SetCMS\Module\UserSession\Exception\UserSessionNotFoundException;

class UserSessionUpdateServant implements ContractServant
{

    use \SetCMS\Traits\DITrait;

    public UserSessionEntity $session;

    public function serve(): void
    {
        $hasById = UserSessionHasByIdDAO::make($this->factory());
        $hasById->id = $this->session->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new UserSessionNotFoundException;
        }

        $saveEntity = UserSessionSaveDAO::make($this->factory());
        $saveEntity->session = $this->session;
        $saveEntity->serve();
    }

}
