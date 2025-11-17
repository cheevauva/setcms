<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

$rootPath = \SetCMS\Bootstrap::instance()->rootPath();

$resources = require $rootPath . '/resources/resources.php';

file_put_contents($rootPath . 'cache/resources.php', sprintf('<?php return %s;', var_export($resources, true)));
