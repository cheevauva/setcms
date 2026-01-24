<?php

declare(strict_types=1);

namespace Module\User\DAO;

use SetCMS\UUID;
use Module\User\Entity\UserEntity;

class UserGetOneByCriteriaDAO extends \UUA\DAO
{

    public UUID $id;
    public protected(set) UserEntity $user;

    #[\Override]
    public function serve(): void
    {
        $user = new UserEntity();
        $user->username = 'user' . microtime(true);

        $this->user = $user;
    }
}
