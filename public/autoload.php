<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../vendor/autoload.php';

$container = new DI\Container();
$container->set('config', require dirname(__DIR__) . '/config.php');
$container->set('connections', require dirname(__DIR__) . '/resources/connections.php');
$container->set('events', require dirname(__DIR__) . '/resources/events.php');
$container->set('acl', require dirname(__DIR__) . '/resources/acl.php');
$container->set('routes', require dirname(__DIR__) . '/resources/routes.php');
$container->set('headers', require dirname(__DIR__) . '/resources/headers.php');
$container->set('basePath', dirname(__DIR__));
