<?php

namespace SetCMS\Module\OAuth;

use SetCMS\HttpStatusCode\NotFound;

class OAuthClientException extends \Exception
{

    public static function notFound()
    {
        return new class() extends OAuthClientException implements NotFound {
            
        };
    }

}
