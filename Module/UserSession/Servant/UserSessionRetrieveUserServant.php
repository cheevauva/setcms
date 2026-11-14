<?php

declare(strict_types=1);

namespace Module\UserSession\Servant;

use SetCMS\UUID;
use Module\UserSession\DAO\UserSessionRetrieveManyByCriteriaDAO;
use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use Module\UserSession\UserSessionEntity;
use Module\User\Entity\UserEntity;

class UserSessionRetrieveUserServant extends \UUA\Servant
{

    public UUID $sessionId;
    public protected(set) ?UserSessionEntity $userSession = null;
    public protected(set) ?UserEntity $user = null;

    #[\Override]
    protected function run(): void
    {
        $userSessionById = UserSessionRetrieveManyByCriteriaDAO::new($this);
        $userSessionById->allowEmptyResult = true;
        $userSessionById->expectOne = true;
        $userSessionById->id = $this->sessionId;
        $userSessionById->limit = 1;
        $userSessionById->serve();

        if (empty($userSessionById->entity)) {
            return;
        }
        
        $userSession = UserSessionEntity::as($userSessionById->entity);

        $userById = UserRetrieveManyByCriteriaDAO::new($this);
        $userById->id = $userSession->userId;
        $userById->allowEmptyResult = true;
        $userById->expectOne = true;
        $userById->limit = 1;
        $userById->serve();

        if (empty($userById->user)) {
            return;
        }

        $this->user = $userById->user;
        $this->userSession = $userSession;
    }
}
