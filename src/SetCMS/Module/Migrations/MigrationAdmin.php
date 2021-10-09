<?php

namespace SetCMS\Module\Migrations;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use SetCMS\Module\Migrations\MigrationService;

class MigrationAdmin
{

    private MigrationService $migrationService;

    public function __construct(MigrationService $migrationService)
    {
        $this->migrationService = $migrationService;
    }
    
    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function index(OrdinaryModelList $model)
    {
        $this->migrationService->list($model);
        
        return $model;
    }

}
