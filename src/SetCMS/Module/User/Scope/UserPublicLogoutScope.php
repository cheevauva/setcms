<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Scope;
use SetCMS\Module\UserSession\DAO\UserSessionDeleteByIdDAO;
use SetCMS\UUID;
use SetCMS\Attribute\Http\Parameter\Cookies;

class UserPublicLogoutScope extends Scope
{

    #[Cookies('X-CSRF-Token')]
    public UUID $token;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserSessionDeleteByIdDAO) {
            $object->id = $this->token;
        }
    }

}
