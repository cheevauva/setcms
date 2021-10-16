<?php

namespace SetCMS\Module\OAuth;

use SetCMS\HttpStatusCode\NotFound;

class OAuthTokenExeption extends \Exception
{

    public static function notFound(string $message = 'Токен не найден')
    {
        return new class($message) extends OAuthTokenExeption implements NotFound {
            
        };
    }

}
