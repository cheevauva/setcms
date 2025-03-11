<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Exception;

class UserIncorrectPasswordException extends UserException
{

    public function __construct(string $message = 'Неверный пароль пользователя')
    {
        parent::__construct($message);
    }

}
