<?php

declare(strict_types=1);

namespace Module\User\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Captcha\Servant\CaptchaUseResolvedCaptchaServant;
use Module\Captcha\Exception\CaptchaException;
use Module\User\Entity\UserEntity;
use Module\User\Exception\UserAlreadyExistsException;
use Module\User\Servant\UserRegistrationServant;
use Module\User\Exception\UserPasswordsNotEqualException;
use Module\User\Exception\UserPasswordMustBeMoreThan8CharactersException;
use Module\User\View\UserPublicDoRegistrationView;
use Module\User\Mapper\UserRegistrationFromRequestMapper;

class UserPublicDoRegistrationController extends ControllerViaPSR7
{

    protected string $email;
    protected string $password;
    protected string $password2;
    protected ?UUID $captcha;
    protected UserEntity $user;
    protected bool $useCaptcha;

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->useCaptcha = boolval($this->env()['CAPTCHA_USE_USER_REGISTRATION'] ?? true);
    }

    #[\Override]
    protected function domainUnits(): array
    {
        return array_filter([
            UserRegistrationFromRequestMapper::class,
            $this->useCaptcha ? CaptchaUseResolvedCaptchaServant::class : null,
            UserRegistrationServant::class,
        ]);
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicDoRegistrationView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserRegistrationFromRequestMapper) {
            $object->useCaptcha = $this->useCaptcha;
        }

        if ($object instanceof CaptchaUseResolvedCaptchaServant) {
            $object->captcha = $this->captcha ?? throw new \Exception('captcha undefined');
        }

        if ($object instanceof UserRegistrationServant) {
            $object->email = $this->email;
            $object->password = $this->password;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserRegistrationFromRequestMapper) {
            $this->email = $object->email;
            $this->password = $object->password;
            $this->captcha = $object->captcha;
        }

        if ($object instanceof UserRegistrationServant) {
            $this->user = $object->user;
        }
    }

    #[\Override]
    protected function catch(\Throwable $object): void
    {
        if ($object instanceof UserPasswordsNotEqualException) {
            $this->messages->attach($object, 'password');
            $this->messages->attach($object, 'password2');
        }

        if ($object instanceof UserPasswordMustBeMoreThan8CharactersException) {
            $this->messages->attach($object, 'password');
        }

        if ($object instanceof CaptchaException) {
            $this->messages->attach($object, 'captcha');
        }

        if ($object instanceof UserAlreadyExistsException) {
            $this->messages->attach($object, 'email');
        }
    }
}
