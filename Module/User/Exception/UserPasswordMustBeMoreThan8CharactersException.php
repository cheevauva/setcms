<?php

declare(strict_types=1);

namespace Module\User\Exception;

class UserPasswordMustBeMoreThan8CharactersException extends UserException
{

    /**
     * @var string
     */
    protected $message = 'Пароль должен содержать минимум 8 символов';
}
