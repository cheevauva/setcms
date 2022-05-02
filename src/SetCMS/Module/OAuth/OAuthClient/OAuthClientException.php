<?php

namespace SetCMS\Module\OAuth\OAuthClient;

class OAuthClientException extends \Exception
{

    public static function autorizationNotAllow($message = 'Для клиент-приложения запрещена авторизация'): self
    {
        return new static($message);
    }

    public static function internalError(string $message): self
    {
        return new static($message);
    }

    public static function autorizationCodeFail(string $message)
    {
        return self::internalError($message);
    }

    public static function notFound(string $message = 'Клиент-приложение не найдено'): self
    {
        return new static($message);
    }

}
