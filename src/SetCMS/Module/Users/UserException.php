<?php

namespace SetCMS\Module\Users;

use SetCMS\HttpStatusCode\NotFound;

class UserException extends \Exception
{

    public static function notFound(string $message = 'Пользователь не найден'): self
    {
        return new class($message) extends UserException implements NotFound {
            
        };
    }

    public static function loginFail(): self
    {
        return static::notFound('Пользователь с таким паролем не найден');
    }

    public static function isExistsUsername(): self
    {
        return static::notFound('Такой пользователь уже существует');
    }

}
