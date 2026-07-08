<?php

declare(strict_types=1);

$routes['GET /~/rad99/index AdminRAD99Index'] = \Module\RAD99\Controller\RAD99PrivateIndexController::class;
$routes['GET /~/rad99/read/[g:id] AdminRAD99Read'] = \Module\RAD99\Controller\RAD99PrivateReadController::class;
$routes['GET /~/rad99/new/[g:id] AdminRAD99New'] = \Module\RAD99\Controller\RAD99PrivateNewController::class;
$routes['GET /~/rad99/edit/[g:id] AdminRAD99Edit'] = \Module\RAD99\Controller\RAD99PrivateEditController::class;
$routes['POST /~/rad99/delete/[g:id] AdminRAD99Delete'] = \Module\RAD99\Controller\RAD99PrivateDeleteController::class;
$routes['POST /~/rad99/update/[g:id] AdminRAD99Update'] = \Module\RAD99\Controller\RAD99PrivateUpdateController::class;
$routes['POST /~/rad99/create/[g:id] AdminRAD99Create'] = \Module\RAD99\Controller\RAD99PrivateCreateController::class;
