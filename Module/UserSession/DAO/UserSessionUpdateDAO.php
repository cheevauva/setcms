<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use Module\UserSession\Mapper\UserSessionToRowMapper;
use Module\UserSession\UserSessionEntity;
use SetCMS\Entity\DAO\EntityUpdateDAO;

class UserSessionUpdateDAO extends EntityUpdateDAO
{

    use \Module\UserSession\Traits\UserSessionDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return UserSessionToRowMapper::call($this, $this->entity)->row;
    }
}
