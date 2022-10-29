<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Scope;

use SetCMS\Module\Module01\Entity01Entity;

class Module01PrivateCreateScope extends \SetCMS\Entity\Scope\EntityCreateScope
{

    use Module01PrivateEntityScopeTrait;

    protected function entity(): Entity01Entity
    {
        return new Entity01Entity;
    }

}
