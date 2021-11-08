<?php

namespace SetCMS\Module;

use SetCMS\Module\Module;
use SetCMS\Module\Pages\Page;
use SetCMS\Module\Pages\PageAdmin;
use SetCMS\Module\Pages\PageResource;
use SetCMS\Module\Modules\Contract\ModuleAdminInterface;
use SetCMS\Module\Modules\Contract\ModuleResourceInterface;

class Pages extends Module implements ModuleAdminInterface, ModuleResourceInterface
{

    public function getResource(): string
    {
        return 'page';
    }

    public function getEntityClassName(): string
    {
        return Page::class;
    }

    public function getAdminControllerClassName(): string
    {
        return PageAdmin::class;
    }

    public function getResourceControllerClassName(): string
    {
        return PageResource::class;
    }

}
