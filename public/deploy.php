<?php

require_once 'autoload.php';

use SetCMS\Module\Migrations\MigrationService;


$migrationService = $container->get(MigrationService::class);

assert($migrationService instanceof MigrationService);

$migrationService->migrate();