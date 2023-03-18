<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Scope;
use SetCMS\Module\User\Servant\UserLoginServant;
use SetCMS\Module\User\UserEntity;
use SetCMS\Module\UserSession\UserSessionEntity;
use SetCMS\Module\UserSession\Servant\UserSessionCreateByUserServant;
use SetCMS\Attribute;

class UserPublicDoLoginScope extends Scope
{

    #[Attribute\NotBlank]
    public string $username;

    #[Attribute\NotBlank]
    public string $password;
    public string $device = '';
    // public string $captcha;
    protected ?UserEntity $user = null;
    protected ?UserSessionEntity $session = null;

    public function to(object $object): void
    {
        parent::to($object);

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
