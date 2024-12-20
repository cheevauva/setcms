<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\Entity\UserEntity;

class UserSaveDAO extends \SetCMS\Common\DAO\Entity\EntitySaveDAO
{

    use UserCommonDAO;

    public UserEntity $user;

    public function serve(): void
    {
        $this->entity = $this->user;

        parent::serve();
    }

}
