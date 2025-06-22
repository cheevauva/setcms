<?php

declare(strict_types=1);

$routes['GET /~/Entity01LC/index AdminModule01Index'] = \SetCMS\Module\Module01\Controller\Entity01PrivateIndexController::class;
$routes['GET /~/Entity01LC/read/[g:id] AdminModule01Read'] = \SetCMS\Module\Module01\Controller\Entity01PrivateReadController::class;
$routes['GET /~/Entity01LC/new/[g:id] AdminModule01New'] = \SetCMS\Module\Module01\Controller\Entity01PrivateNewController::class;
$routes['GET /~/Entity01LC/edit/[g:id] AdminModule01Edit'] = \SetCMS\Module\Module01\Controller\Entity01PrivateEditController::class;
$routes['POST /~/Entity01LC/update/[g:id] AdminModule01Update'] = \SetCMS\Module\Module01\Controller\Entity01PrivateUpdateController::class;
$routes['POST /~/Entity01LC/create/[g:id] AdminModule01Create'] = \SetCMS\Module\Module01\Controller\Entity01PrivateCreateController::class;
