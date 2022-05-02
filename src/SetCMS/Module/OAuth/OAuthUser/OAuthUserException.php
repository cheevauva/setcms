<?php

namespace SetCMS\Module\OAuth\OAuthUser;

class OAuthUserException extends \Exception
{

    public static function internalError(string $message): self
    {
        return new static($message);
    }

    public static function autorizationCodeFail(string $message): self
    {
        return self::internalError($message);
    }

    public static function notFound(): self
    {
        return new static('Пользователь не найден');
    }

}
