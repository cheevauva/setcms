<?php

namespace SetCMS\Module;

use SetCMS\Module\Modules\Contract\ModuleAdminInterface;
use SetCMS\Module\Modules\Contract\ModuleResourceInterface;
use SetCMS\Module\Module;
use SetCMS\Module\Blocks\Block;
use SetCMS\Module\Blocks\BlockAdmin;
use SetCMS\Module\Blocks\BlockResource;

class Blocks extends Module implements ModuleAdminInterface, ModuleResourceInterface
{

    public function getResource(): string
    {
        return 'block';
    }

    public function getEntityClassName(): string
    {
        return Block::class;
    }

    public function getAdminControllerClassName(): string
    {
        return BlockAdmin::class;
    }

    public function getResourceControllerClassName(): string
    {
        return BlockResource::class;
    }

}
