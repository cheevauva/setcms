<?php

namespace SetCMS\Module;

use SetCMS\Module\Modules\Contract\ModuleAdminInterface;
use SetCMS\Module\Module;
use SetCMS\Module\Modules\ModuleAdmin;

class Modules extends Module implements ModuleAdminInterface
{

    public function getAdminControllerClassName(): string
    {
        return ModuleAdmin::class;
    }

}
