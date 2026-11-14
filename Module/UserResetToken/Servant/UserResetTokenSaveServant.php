<?php

declare(strict_types=1);

namespace Module\UserResetToken\Servant;

use Module\UserResetToken\DAO\UserResetTokenCreateDAO;
use Module\UserResetToken\DAO\UserResetTokenUpdateDAO;

class UserResetTokenSaveServant extends \UUA\Servant
{

    use \SetCMS\Entity\Traits\EntityCallTrait;

    #[\Override]
    protected function run(): void
    {
        if (!empty($this->entity->id)) {
            UserResetTokenUpdateDAO::call($this, $this->entity);
        } else {
            UserResetTokenCreateDAO::call($this, $this->entity);
        }
    }
}
