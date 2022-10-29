<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\Scope;

class OAuthClientPrivateUpdateScope extends \SetCMS\Entity\Scope\EntityUpdateScope
{
    use OAuthClientPrivateSaveScopeTrait;
    

}
