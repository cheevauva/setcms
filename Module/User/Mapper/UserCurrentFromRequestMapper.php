<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use Module\User\Entity\UserEntity;

class UserCurrentFromRequestMapper extends \SetCMS\Mapper\MapperFromRequest
{

    public protected(set) UserEntity $user;

    #[\Override]
    public function serve(): void
    {
        $this->user = UserEntity::as($this->validationAttributes()->object('currentUser')->notEmpty()->notQuiet()->val());
    }
}
