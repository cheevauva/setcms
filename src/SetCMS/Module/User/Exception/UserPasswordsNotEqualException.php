<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Exception;

class UserPasswordsNotEqualException extends UserException
{

    public function __construct()
    {
        parent::__construct('Пароли не совпадаю');
    }
}
