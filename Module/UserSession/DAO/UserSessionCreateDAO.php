<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use SetCMS\Entity\DAO\EntityCreateDAO;
use Module\UserSession\Mapper\UserSessionToRowMapper;
use Module\UserSession\UserSessionEntity;

class UserSessionCreateDAO extends EntityCreateDAO
{

    use \Module\UserSession\Traits\UserSessionDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return UserSessionToRowMapper::call($this, $this->entity)->row;
    }
}
