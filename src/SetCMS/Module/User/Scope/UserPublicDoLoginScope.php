<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Module\User\Servant\UserLoginServant;
use SetCMS\Module\User\UserEntity;
use SetCMS\Module\Session\SessionEntity;
use SetCMS\Module\Session\Servant\SessionCreateByUserServant;

class UserPublicDoLoginScope extends \SetCMS\Scope
{

    public string $username;
    public string $password;
    public string $device = '';
    // public string $captcha;
    protected ?UserEntity $user = null;
    protected ?SessionEntity $session = null;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserLoginServant) {
            $object->password = $this->password;
            $object->username = $this->username;
        }

        if ($object instanceof SessionCreateByUserServant) {
            $object->user = $this->user;
            $object->device = $this->device;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof UserLoginServant) {
            $this->user = $object->user;
        }

        if ($object instanceof SessionCreateByUserServant) {
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
