<?php

declare(strict_types=1);

namespace SetCMS\Module\UserResetToken\Servant;

use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\UserResetToken\DAO\UserResetTokenRetrieveManyByCriteriaDAO;
use SetCMS\Module\UserResetToken\Entity\UserResetTokenEntity;
use SetCMS\Module\UserResetToken\DAO\UserResetTokenSaveDAO;
use SetCMS\Module\Template\Servant\TemplateRenderUserResetPasswordServant;

class UserResetTokenSendToUserServant extends \UUA\Servant
{

    use \UUA\Traits\EnvTrait;

    public UserEntity $user;
    public protected(set) ?UserResetTokenEntity $userResetToken = null;

    #[\Override]
    public function serve(): void
    {
        $userResetToken = null;

        if ($this->isRefreshExistsToken()) {
            $retrieveToken = UserResetTokenRetrieveManyByCriteriaDAO::new($this->container);
            $retrieveToken->userId = $this->user->id;
            $retrieveToken->orThrow = false;
            $retrieveToken->serve();

            $userResetToken = $retrieveToken->userResetToken;
        }

        $userResetToken ??= new UserResetTokenEntity();
        $userResetToken->userId = $this->user->id;
        $userResetToken->dateExpired = $this->dateExpired();
        $userResetToken->token = (new \SetCMS\UUID)->uuid;

        $this->userResetToken = $userResetToken;

        $saveUserResetToken = UserResetTokenSaveDAO::new($this->container);
        $saveUserResetToken->userResetToken = $userResetToken;
        $saveUserResetToken->serve();

        $template = TemplateRenderUserResetPasswordServant::new($this->container);
        $template->userResetToken = $userResetToken;
        $template->user = $this->user;
        $template->serve();
    }

    protected function dateExpired(): \DateTimeImmutable
    {
        return new \DateTimeImmutable(sprintf('+%s seconds', $this->env()['USER_RESET_TOKEN_EXPIRED_SECONDS'] ?? 3600));
    }

    protected function isRefreshExistsToken(): bool
    {
        return boolval($this->env()['USER_RESET_TOKEN_REFRESH_EXISTS'] ?? true);
    }
}
