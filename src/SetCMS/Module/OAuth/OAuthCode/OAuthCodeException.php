<?php

namespace SetCMS\Module\OAuth\OAuthCode;

class OAuthCodeException extends \Exception
{

    public static function notFound()
    {
        return new static('Код авторизации не найден');
    }

}
