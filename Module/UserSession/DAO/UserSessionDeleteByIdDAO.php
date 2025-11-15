<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use SetCMS\DAO\EntityCommonDAO;
use Module\UserSession\UserSessionConstrants;
use Module\UserSession\UserSessionEntity;
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
