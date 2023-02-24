<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\Servant;

use SetCMS\ServantInterface;
use SetCMS\Module\User\UserEntity;
use SetCMS\Module\Session\SessionEntity;
use SetCMS\Module\Session\DAO\SessionSaveDAO;

class SessionCreateByUserServant implements ServantInterface
{

    use \SetCMS\FactoryTrait;
    use \SetCMS\DITrait;

    public UserEntity $user;
    public ?SessionEntity $session;
    public string $device;

    public function serve(): void
    {
        $session = new SessionEntity;
        $session->userId = $this->user->id;
        $session->device = '';
        $session->dateExpiries = new \DateTime('+1 year');

        $save = SessionSaveDAO::make($this->factory());
        $save->session = $session;
        $save->serve();

        $this->session = $session;
    }

}
