<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\DAO;

use SetCMS\Entity\DAO\EntitySaveDAO;
use SetCMS\Module\UserSession\UserSessionEntity;

class UserSessionSaveDAO extends EntitySaveDAO
{

    use UserSessionGenericDAO;

    public UserSessionEntity $session;

    public function serve(): void
    {
        $this->entity = $this->session;

        parent::serve();
    }

}
