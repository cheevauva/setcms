<?php

declare(strict_types=1);

namespace Module\User\Exception;

class UserPasswordsNotEqualException extends UserException
{

    /**
     * @var string
     */
    protected $message = 'Пароли не совпадают';
}
