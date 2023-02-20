<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Scope;

use SetCMS\Module\Module01\Entity01Entity;
use SetCMS\Entity\Scope\EntityCreateScope;

class Module01PrivateCreateScope extends EntityCreateScope
{

    use Module01PrivateGenericScope;

    protected function entity(): Entity01Entity
    {
        return new Entity01Entity;
    }

}
