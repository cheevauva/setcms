<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Module\Post\PostEntity;
use SetCMS\Entity\Scope\EntityCreateScope;

class PostPrivateCreateScope extends EntityCreateScope
{

    public PostPrivatePostScope $entity;

    protected function entity(): PostEntity
    {
        return new PostEntity;
    }

}
