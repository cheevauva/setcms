<?php

namespace SetCMS\Module\OAuth;

use SetCMS\HttpStatusCode\NotFound;
use SetCMS\HttpStatusCode\InternalServerError;

class OAuthClientException extends \Exception
{

    public static function internalError(string $message): self
    {
        return new class($message) extends OAuthClientException implements InternalServerError {
            
        };
    }
    
    public static function autorizationCodeFail(string $message)
    {
        return self::internalError($message);
    }

    public static function notFound(string $message = 'Клиент-приложение не найдено'): self
    {
        return new class($message) extends OAuthClientException implements NotFound {
            
        };
    }

}
