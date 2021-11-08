<?php

namespace SetCMS\Module\Modules;

use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Modules\ModuleDAO;

class ModuleService extends OrdinaryService
{

    private ModuleDAO $moduleDAO;

    public function __construct(ModuleDAO $moduleDAO)
    {
        $this->moduleDAO = $moduleDAO;
    }

    protected function dao(): ModuleDAO
    {
        return $this->moduleDAO;
    }

    public function entity(): \SetCMS\Module\Ordinary\OrdinaryEntity
    {
        
    }

}
