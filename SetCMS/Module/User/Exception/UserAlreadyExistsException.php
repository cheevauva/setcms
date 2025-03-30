<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Exception;

class UserAlreadyExistsException extends UserException
{

    public function __construct(string $message = 'Пользователь уже существует')
    {
        parent::__construct($message);
    }
}
