<?php

declare(strict_types=1);

use SetCMS\Scope;

$contentType = 'application/json';
$content = json_encode([
    'main' => Scope::as($scope)->toArray(),
    'sub' => $call('/menu/for/context')->toArray(),
    'sub2' => $call('/sub/configurations/main')->toArray(),
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
