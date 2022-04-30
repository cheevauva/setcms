<?php

require_once '../bootstrap.php';

use SetCMS\Controller\FrontController;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response;

$response = FrontController::factory($factory)->resolve(ServerRequestFactory::fromGlobals(), new Response);

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();