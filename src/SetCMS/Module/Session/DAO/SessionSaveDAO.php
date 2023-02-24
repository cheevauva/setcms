<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\DAO;

use SetCMS\Entity\DAO\EntitySaveDAO;
use SetCMS\Module\Session\SessionEntity;

class SessionSaveDAO extends EntitySaveDAO
{

    use SessionGenericDAO;

    public SessionEntity $session;

    public function serve(): void
    {
        $this->entity = $this->session;

        parent::serve();
    }

}
