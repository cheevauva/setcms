<?php

declare(strict_types=1);

namespace SetCMS\Module\Session\DAO;

use SetCMS\Entity\DAO\EntityCommonDAO;
use SetCMS\Module\Session\SessionConstrants;
use SetCMS\Module\Session\SessionEntity;
use SetCMS\UUID;

class SessionDeleteByIdDAO extends EntityCommonDAO
{

    use SessionGenericDAO;
    
    public ?SessionEntity $session;
    public ?UUID $id;

    public function serve(): void
    {
        $this->db()->delete(SessionConstrants::TABLE_NAME, [
            'id' => strval(isset($this->session) ? $this->session->id : $this->id),
        ]);
    }

}
