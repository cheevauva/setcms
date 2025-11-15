<?php

declare(strict_types=1);

namespace Module\User\Exception;

class UserIncorrectPasswordException extends UserException
{

    /**
     * @var string
     */
    protected $message = 'Неверный пароль пользователя';
}
