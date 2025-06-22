<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\UserResetToken\DAO\UserResetTokenRetrieveManyByCriteriaDAO;
use SetCMS\Module\UserResetToken\Entity\UserResetTokenEntity;
use SetCMS\Module\UserResetToken\DAO\UserResetTokenSaveDAO;

class UserResetPasswordLinkServitor extends \UUA\Servant
{

    use \UUA\Traits\EnvTrait;

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

        $dateExpired = new \DateTimeImmutable(sprintf('+%s seconds', $this->env()['USER_RESET_TOKEN_EXPIRED_SECONDS'] ?? 3600));

        $userResetToken = null;

        if (boolval($this->env()['USER_RESET_TOKEN_REFRESH_EXISTS'] ?? true)) {
            $retrieveToken = UserResetTokenRetrieveManyByCriteriaDAO::new($this->container);
            $retrieveToken->userId = $user->id;
            $retrieveToken->orThrow = false;
            $retrieveToken->serve();

            $userResetToken = $retrieveToken->userResetToken;
        }

        $userResetToken ??= new UserResetTokenEntity();
        $userResetToken->userId = $user->id;
        $userResetToken->dateExpired = $dateExpired;
        $userResetToken->token = (new \SetCMS\UUID)->uuid;
        
        $saveUserResetToken = UserResetTokenSaveDAO::new($this->container);
        $saveUserResetToken->userResetToken = $userResetToken;
        $saveUserResetToken->serve();
    }
}
