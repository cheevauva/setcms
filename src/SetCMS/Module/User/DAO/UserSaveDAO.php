<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\UserEntity;

class UserSaveDAO extends \SetCMS\Common\DAO\Entity\EntitySaveDAO
{

    use UserEntityDbDAOTrait;

    public UserEntity $user;

    public function serve(): void
    {
        $this->entity = $this->user;

        parent::serve();
    }

}
