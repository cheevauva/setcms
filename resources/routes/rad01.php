<?php

declare(strict_types=1);

$routes['GET /~/rad01/index AdminRAD01Index'] = \Module\RAD01\Controller\RAD01PrivateIndexController::class;
$routes['GET /~/rad01/read/[g:id] AdminRAD01Read'] = \Module\RAD01\Controller\RAD01PrivateReadController::class;
$routes['GET /~/rad01/new/[g:id] AdminRAD01New'] = \Module\RAD01\Controller\RAD01PrivateNewController::class;
$routes['GET /~/rad01/edit/[g:id] AdminRAD01Edit'] = \Module\RAD01\Controller\RAD01PrivateEditController::class;
$routes['POST /~/rad01/delete/[g:id] AdminRAD01Delete'] = \Module\RAD01\Controller\RAD01PrivateDeleteController::class;
$routes['POST /~/rad01/update/[g:id] AdminRAD01Update'] = \Module\RAD01\Controller\RAD01PrivateUpdateController::class;
$routes['POST /~/rad01/create/[g:id] AdminRAD01Create'] = \Module\RAD01\Controller\RAD01PrivateCreateController::class;
