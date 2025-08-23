<?php

$start = microtime(true);

require_once 'bootstrap.php';

use Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response;
use SetCMS\Application\Middleware\Servant\MiddlewareDispatcherServant;

$middlewareDispatcher = MiddlewareDispatcherServant::new($container);
$middlewareDispatcher->middlewares = $container->get('middlewares');
$middlewareDispatcher->request = ServerRequestFactory::fromGlobals();
$middlewareDispatcher->response = new Response;
$middlewareDispatcher->serve();

$response = $middlewareDispatcher->response;
$response = $response->withHeader('X-SetCMS-Execution-Time', strval(microtime(true) - $start));
$response = $response->withHeader('X-SetCMS-Memory-Peak-Usage', strval(memory_get_peak_usage() / (1024 * 1024)));

$emitter = new SapiStreamEmitter;
$emitter->emit($response);
