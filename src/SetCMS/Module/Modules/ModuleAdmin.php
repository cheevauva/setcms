<?php

namespace SetCMS\Module\Modules;

use SetCMS\Module\Ordinary\OrdinaryController;
use SetCMS\Module\Modules\ModuleService;

class ModuleAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryControllerTrait;

    public function __construct(ModuleService $moduleService, OrdinaryController $ordinary)
    {
        $this->ordinary($ordinary);
        $this->ordinary()->service($moduleService);
    }

}
