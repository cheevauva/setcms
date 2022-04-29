<?php

require_once '../bootstrap.php';

use SetCMS\FrontController\FrontControllerServant;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response;

$frontController = FrontControllerServant::factory($factory);
$frontController->request = ServerRequestFactory::fromGlobals();;
$frontController->response = new Response;
$frontController->serve();

$response = $frontController->response;

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();