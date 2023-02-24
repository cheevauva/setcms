<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Servant;

use SetCMS\ServantInterface;
use SetCMS\Contract\Applicable;
use SetCMS\UUID;
use SetCMS\Module\Session\DAO\SessionRetrieveByIdDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;
use SetCMS\Controller\Event\FrontControllerResolveEvent as Event;
use SetCMS\Module\Session\SessionEntity;
use SetCMS\Module\User\UserEntity;

class SessionRetrieveUserServant implements ServantInterface, Applicable
{

    use \SetCMS\DITrait;

    public string $token;
    public ?SessionEntity $session = null;
    public ?UserEntity $user = null;
    private ?Event $event = null;

    public function serve(): void
    {
        try {
            $sessionId = new UUID($this->token);
        } catch (\Exception $ex) {
            return;
        }
        
        $retrieveSession = SessionRetrieveByIdDAO::make($this->factory());
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

        if ($this->event) {
            $this->event->withUser($this->user);
        }
    }

    public function apply(object $object): void
    {
        if ($object instanceof Event) {
            $this->event = $object;
            $this->token = $object->token;
        }
    }

}
