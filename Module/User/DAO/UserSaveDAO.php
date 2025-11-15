<?php

declare(strict_types=1);

namespace Module\User\DAO;

use Module\User\Entity\UserEntity;

class UserSaveDAO extends \SetCMS\DAO\EntitySaveDAO
{

    use UserCommonDAO;

    public UserEntity $user;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->user;

        parent::serve();
    }
}
