<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Scope;
use SetCMS\Module\UserSession\DAO\UserSessionDeleteByIdDAO;
use SetCMS\UUID;

class UserPublicLogoutScope extends Scope
{

    public UUID $token;

    public function to(object $object): void
    {
        if ($object instanceof UserSessionDeleteByIdDAO) {
            $object->id = $this->token;
        }
    }

}
