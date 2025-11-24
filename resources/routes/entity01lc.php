<?php

declare(strict_types=1);

$routes['GET /~/entity01lc/index AdminModule01Index'] = \Module\Module01\Controller\Entity01PrivateIndexController::class;
$routes['GET /~/entity01lc/read/[g:id] AdminModule01Read'] = \Module\Module01\Controller\Entity01PrivateReadController::class;
$routes['GET /~/entity01lc/new/[g:id] AdminModule01New'] = \Module\Module01\Controller\Entity01PrivateNewController::class;
$routes['GET /~/entity01lc/edit/[g:id] AdminModule01Edit'] = \Module\Module01\Controller\Entity01PrivateEditController::class;
$routes['POST /~/entity01lc/update/[g:id] AdminModule01Update'] = \Module\Module01\Controller\Entity01PrivateUpdateController::class;
$routes['POST /~/entity01lc/create/[g:id] AdminModule01Create'] = \Module\Module01\Controller\Entity01PrivateCreateController::class;
