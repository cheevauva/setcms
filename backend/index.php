<?php

$start = microtime(true);

require_once '../bootstrap.php';

use SetCMS\Controller\FrontController;
use Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response;

$response = (new FrontController)->resolve(ServerRequestFactory::fromGlobals(), new Response, $container);
$response = $response->withHeader('X-SetCMS-Execution-Time', strval(microtime(true) - $start));
$response = $response->withHeader('X-SetCMS-Memory-Peak-Usage', strval(memory_get_peak_usage() / (1024 * 1024)));

$emitter = new SapiStreamEmitter;
$emitter->emit($response);