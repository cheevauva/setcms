<?php

declare(strict_types=1);

namespace SetCMS\Module\UserResetToken\Servant;

use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\UserResetToken\DAO\UserResetTokenRetrieveManyByCriteriaDAO;
use SetCMS\Module\UserResetToken\Entity\UserResetTokenEntity;
use SetCMS\Module\UserResetToken\DAO\UserResetTokenSaveDAO;
use SetCMS\Module\Template\Servant\TemplateRenderUserResetPasswordServant;

class UserResetTokenLinkServant extends \UUA\Servant
{

    use \UUA\Traits\EnvTrait;

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

        $user = $retrieveUser->user;

        $userResetToken = null;

        if ($this->isRefreshExistsToken()) {
            $retrieveToken = UserResetTokenRetrieveManyByCriteriaDAO::new($this->container);
            $retrieveToken->userId = $user->id;
            $retrieveToken->orThrow = false;
            $retrieveToken->serve();

            $userResetToken = $retrieveToken->userResetToken;
        }

        $userResetToken ??= new UserResetTokenEntity();
        $userResetToken->userId = $user->id;
        $userResetToken->dateExpired = $this->dateExpired();
        $userResetToken->token = (new \SetCMS\UUID)->uuid;

        $saveUserResetToken = UserResetTokenSaveDAO::new($this->container);
        $saveUserResetToken->userResetToken = $userResetToken;
        $saveUserResetToken->serve();

        $template = TemplateRenderUserResetPasswordServant::new($this->container);
        $template->userResetToken = $userResetToken;
        $template->user = $user;
        $template->serve();
        
        print_r($template->templateRendered);die;
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
