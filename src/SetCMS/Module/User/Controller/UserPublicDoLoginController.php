<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\Controller;
use SetCMS\Module\User\Servant\UserLoginServant;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\Captcha\Servant\CaptchaUseResolvedCaptchaServant;
use SetCMS\Module\UserSession\Servant\UserSessionCreateByUserServant;
use SetCMS\Module\Captcha\Exception\CaptchaException;
use SetCMS\Module\User\Exception\UserNotFoundException;
use SetCMS\Module\User\Exception\UserIncorrectPasswordException;
use SetCMS\Module\User\View\UserPublicDoLoginView;
use SetCMS\UUID;
use SetCMS\Attribute\Http\RequestMethod;

#[RequestMethod('POST')]
class UserPublicDoLoginController extends Controller
{

    protected string $username;
    protected string $password;
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

        $this->username = $validationBody->string('username')->notEmpty()->val();
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
            $object->username = $this->username;
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
            $this->messages->attach($object, 'username');
        }

        if ($object instanceof UserIncorrectPasswordException) {
            $this->messages->attach($object, 'password');
        }

        if ($object instanceof CaptchaException) {
            $this->messages->attach($object, 'captcha');
        }
    }
}
