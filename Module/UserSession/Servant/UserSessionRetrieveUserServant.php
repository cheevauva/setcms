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

    public string $token;
    public ?UserSessionEntity $userSession = null;
    public ?UserEntity $user = null;

    #[\Override]
    public function serve(): void
    {
        try {
            $sessionId = new UUID($this->token);
        } catch (\Exception $ex) {
            return;
        }

        $retrieveSession = UserSessionRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveSession->allowEmptyResult = true;
        $retrieveSession->expectOne = true;
        $retrieveSession->id = $sessionId;
        $retrieveSession->limit = 1;
        $retrieveSession->serve();

        if (empty($retrieveSession->userSession)) {
            return;
        }

        $retrieveUser = UserRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveUser->id = $retrieveSession->userSession->userId;
        $retrieveUser->allowEmptyResult = true;
        $retrieveUser->expectOne = true;
        $retrieveUser->limit = 1;
        $retrieveUser->serve();

        if (empty($retrieveUser->user)) {
            return;
        }

        $this->user = $retrieveUser->user;
        $this->userSession = $retrieveSession->userSession;
    }
}
