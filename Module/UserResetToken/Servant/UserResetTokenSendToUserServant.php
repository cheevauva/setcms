<?php

declare(strict_types=1);

namespace Module\UserResetToken\Servant;

use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use Module\User\Entity\UserEntity;
use Module\UserResetToken\DAO\UserResetTokenRetrieveManyByCriteriaDAO;
use Module\UserResetToken\Entity\UserResetTokenEntity;
use Module\UserResetToken\DAO\UserResetTokenSaveDAO;
use Module\Template\Servant\TemplateRenderUserResetPasswordServant;
use Module\Email\Servant\EmailSendServant;
use Module\Email\Entity\EmailEntity;

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

        $email = new EmailEntity();
        $email->subject = $template->templateRendered->title;
        $email->body = $template->templateRendered->content;
        $email->to = $this->user->email;
        $email->from = strval($this->env()['EMAIL_ADDRESS_FOR_SENDING_SERVICE_MESSAGES']);

        $sendEmail = EmailSendServant::new($this->container);
        $sendEmail->email = $email;
        $sendEmail->immediate = false;
        $sendEmail->serve();
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
