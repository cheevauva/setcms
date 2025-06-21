<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\UUID;
use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Captcha\Servant\CaptchaUseResolvedCaptchaServant;
use SetCMS\Module\Captcha\Exception\CaptchaException;
use SetCMS\Module\User\View\UserPublicDoRestoreView;
use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\Exception\UserException;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\Servant\UserResetPasswordLinkServitor;

class UserPublicDoRestoreController extends ControllerViaPSR7
{

    protected bool $useCaptcha = false;
    protected string $email;
    protected UUID $captcha;
    protected UserEntity $user;

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->useCaptcha = boolval($this->env()['CAPTCHA_USE_USER_RESTORE'] ?? true);
    }

    #[\Override]
    protected function domainUnits(): array
    {
        return array_filter([
            $this->useCaptcha ? CaptchaUseResolvedCaptchaServant::class : null,
            UserResetPasswordLinkServitor::class,
        ]);
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicDoRestoreView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaUseResolvedCaptchaServant) {
            $object->captcha = $this->captcha;
        }

        if ($object instanceof UserResetPasswordLinkServitor) {
            $object->email = $this->email;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->email = $validation->string('email')->notEmpty()->val();

        if ($this->useCaptcha) {
            $this->captcha = $validation->uuid('captcha')->notEmpty()->val();
        }
    }

    #[\Override]
    protected function catch(\Throwable $object): void
    {
        parent::catch($object);

        if ($object instanceof UserException) {
            $this->messages->attach($object, 'email');
        }

        if ($object instanceof CaptchaException) {
            $this->messages->attach($object, 'captcha');
        }
    }
}
