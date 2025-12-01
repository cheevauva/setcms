<?php

declare(strict_types=1);

namespace Module\UserSession\Servant;

use Module\User\Entity\UserEntity;
use Module\UserSession\UserSessionEntity;
use Module\UserSession\DAO\UserSessionSaveDAO;

class UserSessionCreateByUserServant extends \UUA\Servant
{

    public UserEntity $user;
    public string $device;
    public protected(set) UserSessionEntity $session;

    public function serve(): void
    {
        $session = new UserSessionEntity;
        $session->userId = $this->user->id;
        $session->device = $this->device;
        $session->dateExpiries = new \DateTime('+1 year');
        $session->createdBy = $this->user->id;

        $save = UserSessionSaveDAO::new($this->container);
        $save->session = $session;
        $save->serve();

        $this->session = $session;
    }
}
