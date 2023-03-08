<?php

declare(strict_types=1);

namespace SetCMS\Module\UserSession\DAO;

use SetCMS\Entity\DAO\EntityCommonDAO;
use SetCMS\Module\UserSession\UserSessionConstrants;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\UUID;

class UserSessionDeleteByIdDAO extends EntityCommonDAO
{

    use UserSessionGenericDAO;
    
    public ?UserSessionEntity $session;
    public ?UUID $id;

    public function serve(): void
    {
        $this->db()->delete(UserSessionConstrants::TABLE_NAME, [
            'id' => strval(isset($this->session) ? $this->session->id : $this->id),
        ]);
    }

}
