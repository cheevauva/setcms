<?php

$start = microtime(true);

require_once '../bootstrap.php';

use SetCMS\Controller\FrontController;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response;

$response = (new FrontController)->resolve(ServerRequestFactory::fromGlobals(), new Response, $factory);
$response = $response->withHeader('X-SetCMS-Execution-Time', strval(microtime(true) - $start));
$response = $response->withHeader('X-SetCMS-Memory-Peak-Usage', strval(memory_get_peak_usage() / (1024 * 1024)));

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
