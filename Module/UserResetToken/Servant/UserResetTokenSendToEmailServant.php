<?php

declare(strict_types=1);

namespace Module\UserResetToken\Servant;

use Module\UserResetToken\Servant\UserResetTokenSendToUserServant;
use Module\User\DAO\UserRetrieveManyByCriteriaDAO;

class UserResetTokenSendToEmailServant extends \UUA\Servant
{

    public string $email;
    public protected(set) bool $success = false;

    #[\Override]
    public function serve(): void
    {
        $retrieveUser = UserRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveUser->email = $this->email;
        $retrieveUser->limit = 1;
        $retrieveUser->expectOne = true;
        $retrieveUser->allowEmptyResult = true;
        $retrieveUser->serve();

        if (empty($retrieveUser->userOrNull)) {
            return;
        }

        $sendToUser = UserResetTokenSendToUserServant::new($this->container);
        $sendToUser->user = $retrieveUser->user;
        $sendToUser->serve();

        $this->success = true;
    }
}
