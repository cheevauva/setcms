<?php

declare(strict_types=1);

use SetCMS\Servant\ViewCompositeRender;

assert($this instanceof ViewCompositeRender);

$contentType = 'application/json';
$content = json_encode([
    'main' => $scope->toArray(),
    'sub' => $this->scFetch('/menu/for/context'),
    'sub2' => $this->scFetch('/sub/configurations/main'),
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

