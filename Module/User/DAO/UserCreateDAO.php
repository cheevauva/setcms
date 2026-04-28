<?php

declare(strict_types=1);

namespace Module\User\DAO;

use Module\User\Mapper\UserToRowMapper;

class UserCreateDAO extends \UUA\DAO
{

    use \Module\User\Traits\UserCallTrait;
    use \Module\User\Traits\UserDbalTrait;
    use \SetCMS\DAO\DAOEntityCreateTrait;

    #[\Override]
    protected function row(): array
    {
        return UserToRowMapper::call($this->container, $this->user)->row;
    }
}
