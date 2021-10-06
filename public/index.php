<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../vendor/autoload.php';

$container = new DI\Container();
$container->set('config', require dirname(__DIR__) . '/config.php');
$container->set('basePath', dirname(__DIR__));

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals();

$frontController = $container->make(\SetCMS\FrontController::class, [
    'basePath' => $container->get('basePath'),
    'config' => $container->get('config'),
]);

assert($frontController instanceof \SetCMS\FrontController);
$response = $frontController->execute($request, new \Laminas\Diactoros\Response);

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
