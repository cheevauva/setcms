<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../vendor/autoload.php';

use SetCMS\Module\Migrations\MigrationService;

$container = new DI\Container();
$container->set('config', require dirname(__DIR__) . '/config.php');
$container->set('connections', require dirname(__DIR__) . '/resources/connections.php');
$container->set('basePath', dirname(__DIR__));


$migrationService = $container->get(MigrationService::class);

assert($migrationService instanceof MigrationService);

$migrationService->migrate();