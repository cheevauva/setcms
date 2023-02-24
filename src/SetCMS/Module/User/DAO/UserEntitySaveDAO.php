<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

use SetCMS\Module\User\UserEntity;

class UserEntitySaveDAO extends \SetCMS\Entity\DAO\EntitySaveDAO
{

    use UserEntityDbDAOTrait;

    public UserEntity $user;

    public function serve(): void
    {
        $this->entity = $this->user;
        
        parent::serve();
    }

}
