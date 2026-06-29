<?php

declare(strict_types=1);

namespace Module\User\DAO;

use Module\User\Mapper\UserToRowMapper;

class UserUpdateDAO extends \SetCMS\Entity\DAO\EntityUpdateDAO
{

    use \Module\User\Traits\UserCallTrait;
    use \Module\User\Traits\UserDbalTrait;

    #[\Override]
    protected function row(): array
    {
        return UserToRowMapper::call($this->container, $this->user)->row;
    }
}
