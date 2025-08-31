<?php

declare(strict_types=1);

$routes['GET /migration/up MigrationUp'] = \SetCMS\Module\Migration\Controller\MigrationPublicUpController::class;
$routes['POST /migration/up MigrationDoUp'] = \SetCMS\Module\Migration\Controller\MigrationPublicDoUpController::class;


