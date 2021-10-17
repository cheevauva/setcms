<?php

namespace SetCMS\Module\OAuth;

use SetCMS\HttpStatusCode\NotFound;

class OAuthCodeException extends \Exception
{

    public static function notFound(string $message = 'Код авторизации не найден')
    {
        return new class($message) extends OAuthClientException implements NotFound {
            
        };
    }

}
