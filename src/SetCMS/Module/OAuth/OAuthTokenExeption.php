<?php

namespace SetCMS\Module\OAuth;

class OAuthTokenExeption extends \Exception
{

    public static function notFound()
    {
        return new class() extends OAuthTokenExeption implements NotFound {
            
        };
    }

}
