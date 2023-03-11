<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Contract\Applicable;
use SetCMS\UUID;
use SetCMS\Module\UserSession\DAO\UserSessionRetrieveByIdDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;
use SetCMS\Controller\Hook\FrontControllerResolveHook;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\User\UserEntity;

class UserSessionRetrieveUserServant implements Servant, Applicable
{

    use \SetCMS\DITrait;

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

        $retrieveSession = UserSessionRetrieveByIdDAO::make($this->factory());
        $retrieveSession->id = $sessionId;
        $retrieveSession->serve();

        if (empty($retrieveSession->session)) {
            return;
        }

        $retrieveUser = UserEntityDbRetrieveByIdDAO::make($this->factory());
        $retrieveUser->id = $retrieveSession->session->userId;
        $retrieveUser->serve();

        if (empty($retrieveUser->user)) {
            return;
        }

        $this->user = $retrieveUser->user;
        $this->session = $retrieveSession->session;
    }

    public function from(object $object): void
    {
        if ($object instanceof FrontControllerResolveHook) {
            $this->token = strval($object->token);
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof FrontControllerResolveHook) {
            $object->withUser($this->user);
        }
    }

}
