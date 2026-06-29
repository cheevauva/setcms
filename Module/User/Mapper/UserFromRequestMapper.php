<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use Module\User\Entity\UserEntity;
use Module\User\Enum\UserRoleEnum;

class UserFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public protected(set) UserEntity $user;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();

        $this->user = new UserEntity();
        $this->user->id = $body->uuid('user.id')->notEmpty()->val();
        $this->user->role = UserRoleEnum::from($body->string('user.role')->notEmpty()->val());
    }
}
