<?php

namespace SetCMS\Module;

use SetCMS\Module\Modules\Contract\ModuleIndexAdminResourceInterface;
use SetCMS\Module\Module;
use SetCMS\Module\Posts\Post;
use SetCMS\Module\Posts\PostIndex;
use SetCMS\Module\Posts\PostAdmin;
use SetCMS\Module\Posts\PostResource;

class Posts extends Module implements ModuleIndexAdminResourceInterface
{

    public function getResource(): string
    {
        return 'post';
    }

    public function getEntityClassName(): string
    {
        return Post::class;
    }

    public function getIndexControllerClassName(): string
    {
        return PostIndex::class;
    }

    public function getAdminControllerClassName(): string
    {
        return PostAdmin::class;
    }

    public function getResourceControllerClassName(): string
    {
        return PostResource::class;
    }

}
