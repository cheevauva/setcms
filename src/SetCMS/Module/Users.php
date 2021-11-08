<?php

namespace SetCMS\Module;

use SetCMS\Module\Module as Module;
use SetCMS\Module\Users\User;
use SetCMS\Module\Users\UserIndex;
use SetCMS\Module\Users\UserAdmin;
use SetCMS\Module\Users\UserResource;
use SetCMS\Module\Modules\Contract\ModuleIndexAdminResourceInterface;

class Users extends Module implements ModuleIndexAdminResourceInterface
{

    public function getResource(): string
    {
        return 'user';
    }

    public function getEntityClassName(): string
    {
        return User::class;
    }

    public function getAdminControllerClassName(): string
    {
        return UserAdmin::class;
    }

    public function getIndexControllerClassName(): string
    {
        return UserIndex::class;
    }

    public function getResourceControllerClassName(): string
    {
        return UserResource::class;
    }

}
