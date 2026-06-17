<?php

declare(strict_types=1);

namespace Module\User\Mapper;

use Module\User\Exception\UserPasswordsNotEqualException;
use Module\User\Exception\UserPasswordMustBeMoreThan8CharactersException;
use SetCMS\UUID;

class UserRegistrationFromRequestMapper extends \SetCMS\Mapper\MapperFromRequest
{

    public bool $useCaptcha = false;
    public protected(set) string $email;
    public protected(set) string $password;
    public protected(set) string $password2;
    public protected(set) ?UUID $captcha = null;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();

        $this->email = $body->string('email')->notEmpty()->val();
        $this->password = $body->string('password')->notEmpty()->val();
        $this->password2 = $body->string('password2')->notEmpty()->val();
        $this->captcha = $this->useCaptcha ? $body->uuid('captcha')->notEmpty()->val() : null;

        if (!empty($this->password) && !empty($this->password2) && $this->password !== $this->password2) {
            throw new UserPasswordsNotEqualException();
        }

        if (mb_strlen($this->password) < 8) {
            throw new UserPasswordMustBeMoreThan8CharactersException();
        }
    }
}
