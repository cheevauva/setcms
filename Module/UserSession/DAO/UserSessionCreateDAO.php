<?php

declare(strict_types=1);

namespace Module\UserSession\DAO;

use Module\UserSession\Mapper\UserSessionToRowMapper;

class UserSessionCreateDAO extends \SetCMS\Entity\DAO\EntityCreateDAO
{

    use \Module\UserSession\Traits\UserSessionCallTrait;
    use \Module\UserSession\Traits\UserSessionDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return UserSessionToRowMapper::call($this->container, $this->userSession)->row;
    }
}
