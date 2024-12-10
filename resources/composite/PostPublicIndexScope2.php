<?php

declare(strict_types=1);

$contentType = 'application/json';
$content = json_encode([
    'main' => $scope,
    'sub' => $call('/menu/for/context'),
    'sub2' => $call('/sub/configurations/main'),
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
