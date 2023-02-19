<?php

namespace SetCMS\Module\OAuth\OAuthAppCode;

use SetCMS\UUID;

class OAuthAppCodeEntity extends \SetCMS\Entity
{

    public string $code;
    public UUID $appId;
    public UUID $userId;

    public function __construct()
    {
        parent::__construct();

        $this->code = strval(new UUID);
    }

}
