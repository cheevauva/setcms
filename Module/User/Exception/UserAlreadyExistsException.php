<?php

declare(strict_types=1);

namespace Module\User\Exception;

class UserAlreadyExistsException extends UserException
{

    /**
     * @var string
     */
    protected $message = 'Пользователь уже существует';

}
