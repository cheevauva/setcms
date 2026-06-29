<?php

declare(strict_types=1);

namespace Module\UserResetToken\DAO;

use Module\UserResetToken\Mapper\UserResetTokenToRowMapper;

class UserResetTokenUpdateDAO extends \SetCMS\Entity\DAO\EntityUpdateDAO
{

    use \Module\UserResetToken\Traits\UserResetTokenCallTrait;
    use \Module\UserResetToken\Traits\UserResetTokenDbalDAOTrait;

    #[\Override]
    protected function row(): array
    {
        return UserResetTokenToRowMapper::call($this->container, $this->userResetToken)->row;
    }
}
