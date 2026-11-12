<?php

require_once __DIR__ . '/vendor/autoload.php';

use SetCMS\Bootstrap;

$container = Bootstrap::instance()->newContainer();

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        error_log("Fatal error: {$error['message']} in {$error['file']}:{$error['line']}");
    }
});

define('ADMIN_USER_UUID', $container->get('env')['ADMIN_USER_UUID'] ?? 'c5e35038-4d12-4d90-be57-f4eb1a45fe35');

return $container;
