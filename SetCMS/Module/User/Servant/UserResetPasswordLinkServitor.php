<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\DAO\UserSaveDAO;
use SetCMS\Module\User\Entity\UserEntity;

class UserResetPasswordLinkServitor extends \UUA\Servant
{

    public string $email;

    #[\Override]
    public function serve(): void
    {
        $retrieveUser = UserRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveUser->email = $this->email;
        $retrieveUser->limit = 1;
        $retrieveUser->orThrow = true;
        $retrieveUser->serve();

        $user = UserEntity::as($retrieveUser->user);
        $user->newResetPasswordTicket();
        
        $saveUser = UserSaveDAO::new($this->container);
        $saveUser->user = $user;
        $saveUser->serve();
    }
}
