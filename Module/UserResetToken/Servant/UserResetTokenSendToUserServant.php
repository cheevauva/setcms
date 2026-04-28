<?php

declare(strict_types=1);

namespace Module\UserResetToken\Servant;

use SetCMS\UUID;
use Module\User\Entity\UserEntity;
use Module\UserResetToken\DAO\UserResetTokenRetrieveManyByCriteriaDAO;
use Module\UserResetToken\Entity\UserResetTokenEntity;
use Module\UserResetToken\Servant\UserResetTokenSaveServant;
use Module\Template\Servant\TemplateRenderUserResetPasswordServant;
use Module\Email\Servant\EmailSendServant;
use Module\Email\Entity\EmailEntity;

class UserResetTokenSendToUserServant extends \UUA\Servant
{

    use \UUA\Traits\EnvTrait;

    public UserEntity $user;
    public protected(set) ?UserResetTokenEntity $userResetToken = null;
    protected bool $isRefreshExistsToken;
    protected int $tokenExpiredSeconds;
    protected string $addressFromSending;

    #[\Override]
    protected function init(): void
    {
        $this->isRefreshExistsToken = boolval($this->env()['USER_RESET_TOKEN_REFRESH_EXISTS'] ?? true);
        $this->tokenExpiredSeconds = intval($this->env()['USER_RESET_TOKEN_EXPIRED_SECONDS'] ?? 3600);
        $this->addressFromSending = strval($this->env()['EMAIL_ADDRESS_FOR_SENDING_SERVICE_MESSAGES']);
    }

    #[\Override]
    public function serve(): void
    {
        $userResetToken = null;

        if ($this->isRefreshExistsToken) {
            $getByUserId = UserResetTokenRetrieveManyByCriteriaDAO::new($this->container);
            $getByUserId->userId = $this->user->id;
            $getByUserId->expectOne = true;
            $getByUserId->allowEmptyResult = true;
            $getByUserId->limit = 1;
            $getByUserId->serve();

            $userResetToken = $getByUserId->userResetTokenOrNull;
        }

        $userResetToken ??= new UserResetTokenEntity();
        $userResetToken->userId = $this->user->id;
        $userResetToken->dateExpired = new \DateTimeImmutable(sprintf('+%s seconds', $this->tokenExpiredSeconds));
        $userResetToken->token = (new UUID)->uuid;

        $this->userResetToken = $userResetToken;

        $saveUserResetToken = UserResetTokenSaveServant::new($this->container);
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
        $email->from = $this->addressFromSending;

        $sendEmail = EmailSendServant::new($this->container);
        $sendEmail->email = $email;
        $sendEmail->immediate = false;
        $sendEmail->serve();
    }
}
