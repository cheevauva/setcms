<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\DAO;

use SetCMS\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Module\Session\SessionEntity;

class SessionRetrieveByIdDAO extends EntityRetrieveByIdDAO
{

    use SessionGenericDAO;

    public ?SessionEntity $session;

    public function serve(): void
    {
        parent::serve();

        $this->session = $this->entity;
    }

}
