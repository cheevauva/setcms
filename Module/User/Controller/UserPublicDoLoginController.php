<?php

declare(strict_types=1);

namespace Module\User\Controller;

use SetCMS\ControllerViaPSR7;
use Module\User\Servant\UserLoginServant;
use Module\User\Entity\UserEntity;
use Module\UserSession\UserSessionEntity;
use Module\Captcha\Servant\CaptchaUseResolvedCaptchaServant;
use Module\UserSession\Servant\UserSessionCreateByUserServant;
use Module\Captcha\Exception\CaptchaException;
use Module\User\Exception\UserNotFoundException;
use Module\User\Exception\UserIncorrectPasswordException;
use Module\User\View\UserPublicDoLoginView;
use SetCMS\UUID;

class UserPublicDoLoginController extends ControllerViaPSR7
{

    protected string $username;
    protected string $password;
    protected string $email;
    protected UUID $captcha;
    protected string $device;
    protected UserEntity $user;
    protected UserSessionEntity $session;
    protected string $sessionId;
    protected bool $useCaptcha = false;

    #[\Override]
    protected function init(): void
    {
        parent::init();

        $this->useCaptcha = boolval($this->env()['CAPTCHA_USE_USER_LOGIN'] ?? true);
    }

    #[\Override]
    protected function domainUnits(): array
    {
        return array_filter([
            $this->useCaptcha ? CaptchaUseResolvedCaptchaServant::class : null,
            UserLoginServant::class,
            UserSessionCreateByUserServant::class,
        ]);
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            UserPublicDoLoginView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validationBody = $this->validation($this->request->getParsedBody());
        $validationHeaders = $this->validation([
            'device' => $this->request->getHeaderLine('user-agent')
        ]);

        $this->email = $validationBody->string('email')->notEmpty()->val();
        $this->password = $validationBody->string('password')->notEmpty()->val();
        $this->device = $validationHeaders->string('device')->notEmpty()->val();

        if ($this->useCaptcha) {
            $this->captcha = $validationBody->uuid('captcha')->notEmpty()->val();
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaUseResolvedCaptchaServant) {
            $object->captcha = $this->captcha;
        }

        if ($object instanceof UserLoginServant) {
            $object->password = $this->password;
            $object->email = $this->email;
        }

        if ($object instanceof UserSessionCreateByUserServant) {
            $object->user = $this->user;
            $object->device = $this->device;
        }

        if ($object instanceof UserPublicDoLoginView && isset($this->session)) {
            $object->sessionId = (string) UserSessionEntity::as($this->session)->id;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserLoginServant) {
            $this->user = $object->user;
        }
        
        if ($object instanceof UserSessionCreateByUserServant) {
            $this->session = $object->session;
        }
    }

    #[\Override]
    protected function catch(\Throwable $object): void
    {
        parent::catch($object);

        if ($object instanceof UserNotFoundException) {
            $this->messages->attach($object, 'email');
        }

        if ($object instanceof UserIncorrectPasswordException) {
            $this->messages->attach($object, 'password');
        }

        if ($object instanceof CaptchaException) {
            $this->messages->attach($object, 'captcha');
        }
    }
}
