<?php

namespace SetCMS\Module\OAuth\Scope;

class OAuthCallbackScope extends \SetCMS\Scope
{

    public string $client_id;
    public string $code;
    public ?string $cms_token = null;

}
