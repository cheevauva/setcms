<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once 'vendor/autoload.php';

$container = new DI\Container();


$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals();

$frontController = $container->get(\SetCMS\FrontController::class);

assert($frontController instanceof \SetCMS\FrontController);

$response = $frontController->execute($request);

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
