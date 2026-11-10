<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use Module\User\Entity\UserEntity;

class UserCurrentFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) UserEntity $user;

    #[\Override]
    protected function run(): void
    {
        $this->user = UserEntity::as($this->validationAttributes()->object('currentUser')->notEmpty()->notQuiet()->val());
    }
}
