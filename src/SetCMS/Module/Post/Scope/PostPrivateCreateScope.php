<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Module\Post\PostEntity;

class PostPrivateCreateScope extends \SetCMS\Entity\Scope\EntityCreateScope
{

    use PostPrivateGenericScope;

    protected function entity(): PostEntity
    {
        return new PostEntity;
    }

}
