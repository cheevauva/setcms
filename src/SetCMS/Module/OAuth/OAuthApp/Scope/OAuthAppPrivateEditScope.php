<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp\Scope;

class OAuthAppPrivateEditScope extends \SetCMS\Entity\Scope\EntityEditScope implements \SetCMS\Contract\Twigable
{

    public string $name;

}
