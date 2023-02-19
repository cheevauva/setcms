<?php

namespace SetCMS\Module\OAuth\OAuthAppCode;

class OAuthAppCodeException extends \Exception
{

    public static function notFound()
    {
        return new static('Код авторизации не найден');
    }

}
