<?php

declare(strict_types=1);

namespace Module\User\Exception;

class UserPasswordMustBeMoreThan8CharactersException extends UserException
{

    public function __construct()
    {
        parent::__construct('Пароль должен содержать минимум 8 символов');
    }
}
