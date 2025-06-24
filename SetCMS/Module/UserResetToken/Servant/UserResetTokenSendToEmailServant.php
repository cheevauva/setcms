<?php

declare(strict_types=1);

namespace SetCMS\Module\UserResetToken\Servant;

use SetCMS\Module\UserResetToken\Servant\UserResetTokenSendToUserServant;
use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;

class UserResetTokenSendToEmailServant extends \UUA\Servant
{

    public string $email;

    #[\Override]
    public function serve(): void
    {
        $retrieveUser = UserRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveUser->email = $this->email;
        $retrieveUser->limit = 1;
        $retrieveUser->orThrow = false;
        $retrieveUser->serve();

        if (empty($retrieveUser->user)) {
            return;
        }

        $sendToUser = UserResetTokenSendToUserServant::new($this->container);
        $sendToUser->user = $retrieveUser->user;
        $sendToUser->serve();
    }
}
