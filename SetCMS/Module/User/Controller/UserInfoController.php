<?php

namespace SetCMS\Module\User\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\User\Entity\UserEntity;

class UserInfoController extends ControllerViaPSR7
{

    protected UserEntity $user;

    #[\Override]
    protected function process(): void
    {
        $this->user = UserEntity::as($this->validation($this->ctx)->object('currentUser')->notEmpty()->notQuiet()->val());
    }
}
