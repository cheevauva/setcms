<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Servant;

use SetCMS\UUID;
use SetCMS\Module\UserSession\DAO\UserSessionRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\User\Entity\UserEntity;

class UserSessionRetrieveUserServant extends \UUA\Servant
{

    public string $token;
    public ?UserSessionEntity $session = null;
    public ?UserEntity $user = null;

    public function serve(): void
    {
        try {
            $sessionId = new UUID($this->token);
        } catch (\Exception $ex) {
            return;
        }

        $retrieveSession = UserSessionRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveSession->id = $sessionId;
        $retrieveSession->serve();

        if (empty($retrieveSession->session)) {
            return;
        }

        $retrieveUser = UserRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveUser->id = $retrieveSession->session->userId;
        $retrieveUser->serve();

        if (empty($retrieveUser->user)) {
            return;
        }

        $this->user = $retrieveUser->user;
        $this->session = $retrieveSession->session;
    }
}
