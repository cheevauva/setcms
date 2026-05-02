<?php

declare(strict_types=1);

namespace Module\UserSession\Servant;

use Module\User\Entity\UserEntity;
use Module\UserSession\UserSessionEntity;
use Module\UserSession\DAO\UserSessionCreateDAO;

class UserSessionCreateByUserServant extends \UUA\Servant
{

    public UserEntity $user;
    public string $device;
    public protected(set) UserSessionEntity $session;

    #[\Override]
    public function serve(): void
    {
        $session = new UserSessionEntity;
        $session->userId = $this->user->id;
        $session->device = $this->device;
        $session->dateExpiries = new \DateTimeImmutable('+1 year');
        $session->dateCreated = new \DateTimeImmutable();

        $create = UserSessionCreateDAO::new($this->container);
        $create->userSession = $session;
        $create->serve();

        $this->session = $session;
    }
}
