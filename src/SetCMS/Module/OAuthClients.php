<?php

namespace SetCMS\Module;

use SetCMS\Module\OAuth;

class OAuthClients extends \SetCMS\Module
{

    public function getPrefix(): string
    {
        return OAuth::class . '\OAuthClient';
    }

}
