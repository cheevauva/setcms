<?php

namespace SetCMS\Module;

use SetCMS\Module\Module;
use SetCMS\Module\Modules\Contract\ModuleAdminInterface;
use SetCMS\Module\Migrations\MigrationAdmin;

class Migrations extends Module implements ModuleAdminInterface
{

    public function getAdminControllerClassName(): string
    {
        return MigrationAdmin::class;
    }

}
