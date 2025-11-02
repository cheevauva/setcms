<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\UUID;
use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Captcha\Mediator\CaptchaUseResolvedCaptchaMediator;
use SetCMS\Module\Captcha\Exception\CaptchaException;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\Exception\UserAlreadyExistsException;
use SetCMS\Module\User\Servant\UserRegistrationServant;
use SetCMS\Module\User\Exception\UserPasswordsNotEqualException;
use SetCMS\Module\User\Exception\UserPasswordMustBeMoreThan8CharactersException;
use SetCMS\Module\User\View\UserPublicDoRegistrationView;

class UserPublicDoRegistrationController extends ControllerViaPSR7
{

    protected string $email;
    protected string $password;
    protected string $password2;
    protected UUID $captcha;
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
            $this->useCaptcha ? CaptchaUseResolvedCaptchaMediator::class : null,
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
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->email = $validation->string('email')->notEmpty()->val();
        $this->password = $validation->string('password')->notEmpty()->val();
        $this->password2 = $validation->string('password2')->notEmpty()->val();

        if ($this->useCaptcha) {
            $this->captcha = $validation->uuid('captcha')->notEmpty()->val();
        }

        if (!empty($this->password) && !empty($this->password2) && $this->password !== $this->password2) {
            $this->catch(new UserPasswordsNotEqualException());
        }

        if (mb_strlen($this->password) < 8) {
            $this->catch(new UserPasswordMustBeMoreThan8CharactersException());
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaUseResolvedCaptchaMediator) {
            $object->captcha = $this->captcha;
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
