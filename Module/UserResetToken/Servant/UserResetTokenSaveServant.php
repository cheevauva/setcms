<?php

declare(strict_types=1);

namespace Module\UserResetToken\Servant;

use Module\UserResetToken\DAO\UserResetTokenCreateDAO;
use Module\UserResetToken\DAO\UserResetTokenUpdateDAO;

class UserResetTokenSaveServant extends \UUA\Servant
{

    use \Module\UserResetToken\Traits\UserResetTokenCallTrait;

    #[\Override]
    protected function run(): void
    {
        if (!empty($this->userResetToken->id)) {
            UserResetTokenUpdateDAO::call($this, $this->userResetToken);
        } else {
            UserResetTokenCreateDAO::call($this, $this->userResetToken);
        }
    }
}
