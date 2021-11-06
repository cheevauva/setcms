<?php

namespace SetCMS\Module\Users;

use SetCMS\HttpStatusCode\NotFound;
use SetCMS\HttpStatusCode\Forbidden;

class UserException extends \Exception
{

    public static function notFound(string $message = 'Пользователь не найден'): self
    {
        return new class($message) extends UserException implements NotFound {
            
        };
    }

    public static function notAllow(string $message): self
    {
        return new class($message) extends UserException implements Forbidden {
            
        };
    }

    public static function passwordInvalid(): self
    {
        return static::notAllow('Пароль указан неверно');
    }

    public static function onlyAdmin(): self
    {
        return static::notAllow('Только администратор');
    }

    public static function alreadyAuthorized(): self
    {
        return static::notAllow('Пользователь уже авторизован');
    }

    public static function notAuthorized(): self
    {
        return static::notAllow('Пользователь должен быть авторизован');
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
