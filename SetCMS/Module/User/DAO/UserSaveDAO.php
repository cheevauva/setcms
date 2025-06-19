<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\Entity\UserEntity;

class UserSaveDAO extends \SetCMS\Common\DAO\EntitySaveDAO
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
