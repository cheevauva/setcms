<?php

declare(strict_types=1);

$routes['GET /migration/up MigrationUp'] = \Module\Migration\Controller\MigrationPublicUpController::class;
$routes['POST /migration/up MigrationDoUp'] = \Module\Migration\Controller\MigrationPublicDoUpController::class;


