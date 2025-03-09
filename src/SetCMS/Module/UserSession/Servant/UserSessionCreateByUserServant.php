<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\Servant;

use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\UserSession\DAO\UserSessionSaveDAO;

class UserSessionCreateByUserServant extends \UUA\Servant
{

    public UserEntity $user;
    public ?UserSessionEntity $session;
    public string $device;

    public function serve(): void
    {
        $session = new UserSessionEntity;
        $session->userId = $this->user->id;
        $session->device = $this->device;
        $session->dateExpiries = new \DateTime('+1 year');

        $save = UserSessionSaveDAO::new($this->container);
        $save->session = $session;
        $save->serve();

        $this->session = $session;
    }
}
