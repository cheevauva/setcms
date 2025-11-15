<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use SetCMS\Common\DAO\EntitySaveDAO;
use Module\UserSession\UserSessionEntity;

class UserSessionSaveDAO extends EntitySaveDAO
{

    use UserSessionGenericDAO;

    public UserSessionEntity $session;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->session;

        parent::serve();
    }
}
