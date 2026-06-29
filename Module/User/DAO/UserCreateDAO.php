<?php

declare(strict_types=1);

namespace Module\User\DAO;

use Module\User\Mapper\UserToRowMapper;

class UserCreateDAO extends \SetCMS\Entity\DAO\EntityCreateDAO
{

    use \Module\User\Traits\UserCallTrait;
    use \Module\User\Traits\UserDbalTrait;

    #[\Override]
    protected function row(): array
    {
        return UserToRowMapper::call($this->container, $this->user)->row;
    }
}
