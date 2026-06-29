<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use SetCMS\UUID;

class UserLoginFromRequestMapper extends \SetCMS\Request\Mapper\RequestMapper
{

    public bool $useCaptcha = false;
    public protected(set) string $email;
    public protected(set) string $password;
    public protected(set) string $device;
    public protected(set) ?UUID $captcha = null;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();
        $headers = $this->validationHeaders();

        $this->email = $body->string('email')->notEmpty()->val();
        $this->password = $body->string('password')->notEmpty()->val();
        $this->device = $headers->string('user-agent')->notEmpty()->val();

        $this->captcha = $this->useCaptcha ? $body->uuid('captcha')->notEmpty()->val() : null;
    }
}
