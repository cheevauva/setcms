<?php

namespace SetCMS\Module\OAuth;

use SetCMS\HttpStatusCode\NotFound;
use SetCMS\HttpStatusCode\InternalServerError;

class OAuthUserException extends \Exception
{

    public static function internalError(string $message): self
    {
        return new class($message) extends OAuthUserException implements InternalServerError {
            
        };
    }
    
    public static function autorizationCodeFail(string $message)
    {
        return self::internalError($message);
    }

    public static function notFound(string $message = 'Пользователь не найден'): self
    {
        return new class($message) extends OAuthUserException implements NotFound {
            
        };
    }

}
