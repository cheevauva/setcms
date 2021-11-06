<?php

require_once 'autoload.php';

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
