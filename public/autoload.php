<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../vendor/autoload.php';

$container = new DI\Container();
$container->set('basePath', dirname(__DIR__));
$container->set('config', require $container->get('basePath') . '/config.php');
$container->set('connections', require $container->get('basePath') . '/resources/connections.php');
$container->set('events', require $container->get('basePath') . '/resources/events.php');
$container->set('acl', require $container->get('basePath') . '/resources/acl.php');
$container->set('routes', require $container->get('basePath') . '/resources/routes.php');
$container->set('headers', require $container->get('basePath') . '/resources/headers.php');
$container->set('modules', require $container->get('basePath') . '/resources/modules.php');
$container->set('themes', require $container->get('basePath') . '/resources/themes.php');