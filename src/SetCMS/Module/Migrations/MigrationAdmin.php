<?php

namespace SetCMS\Module\Migrations;

use SetCMS\Module\Migrations\MigrationService;

class MigrationAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryIndexTrait;

    private MigrationService $migrationService;

    public function __construct(MigrationService $migrationService)
    {
        $this->migrationService = $this->service($migrationService);
    }

}
