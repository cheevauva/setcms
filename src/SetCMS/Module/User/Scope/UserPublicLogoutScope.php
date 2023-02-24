<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Scope;
use SetCMS\Contract\Twigable;
use SetCMS\Module\Session\DAO\SessionDeleteByIdDAO;
use SetCMS\UUID;

class UserPublicLogoutScope extends Scope implements Twigable
{

    public UUID $token;

    public function to(object $object): void
    {
        if ($object instanceof SessionDeleteByIdDAO) {
            $object->id = $this->token;
        }
    }

}
