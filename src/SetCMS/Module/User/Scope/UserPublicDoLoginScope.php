<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Scope;
use SetCMS\Module\User\Servant\UserLoginServant;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\Captcha\Servant\CaptchaUseResolvedCaptchaServant;
use SetCMS\Module\UserSession\Servant\UserSessionCreateByUserServant;
use SetCMS\Module\Captcha\Exception\CaptchaException;
use SetCMS\Module\User\Exception\UserNotFoundException;
use SetCMS\Module\User\Exception\UserIncorrectPasswordException;
use SetCMS\Attribute\Http\Parameter\Body;
use SetCMS\Attribute\Http\Parameter\Headers;
use SetCMS\Attribute\NotBlank;
use SetCMS\UUID;

class UserPublicDoLoginScope extends Scope
{

    #[NotBlank]
    #[Body('username')]
    public string $username;

    #[NotBlank]
    #[Body('password')]
    public string $password;

    #[Headers('user-agent')]
    public string $device;

    #[Body('captcha')]
    public UUID $captcha;
    //
    protected ?UserEntity $user = null;
    protected ?UserSessionEntity $session = null;

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
    }

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserNotFoundException) {
            $this->catchToMessage('username', $object);
        }

        if ($object instanceof UserIncorrectPasswordException) {
            $this->catchToMessage('password', $object);
        }

        if ($object instanceof CaptchaException) {
            $this->catchToMessage('captcha', $object);
        }

        if ($object instanceof UserLoginServant) {
            $this->user = $object->user;
        }

        if ($object instanceof UserSessionCreateByUserServant) {
            $this->session = $object->session;
        }
    }

    public function toArray(): array
    {
        return [
            'session' => $this->session ? strval($this->session->id) : null,
        ];
    }

}
