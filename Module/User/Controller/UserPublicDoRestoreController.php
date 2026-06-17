<?php

declare(strict_types=1);

namespace Module\User\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Captcha\Servant\CaptchaUseResolvedCaptchaServant;
use Module\Captcha\Exception\CaptchaException;
use Module\User\View\UserPublicDoRestoreView;
use Module\User\Exception\UserException;
use Module\User\Entity\UserEntity;
use Module\UserResetToken\Servant\UserResetTokenSendToEmailServant;
use Module\User\Mapper\UserRestoreFromRequstMapper;

class UserPublicDoRestoreController extends ControllerViaPSR7
{

    protected bool $useCaptcha = false;
    protected string $email;
    protected ?UUID $captcha = null;
    protected UserEntity $user;
    protected ?string $customTemplate = null;

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
            UserRestoreFromRequstMapper::class,
            $this->useCaptcha ? CaptchaUseResolvedCaptchaServant::class : null,
            UserResetTokenSendToEmailServant::class,
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

        if ($object instanceof UserRestoreFromRequstMapper) {
            $object->useCaptcha = $this->useCaptcha;
        }

        if ($object instanceof CaptchaUseResolvedCaptchaServant) {
            $object->captcha = $this->captcha ?? throw new \Exception('captcha undefined');
        }

        if ($object instanceof UserResetTokenSendToEmailServant) {
            $object->email = $this->email;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRestoreFromRequstMapper) {
            $this->email = $object->email;
            $this->captcha = $object->captcha;
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
