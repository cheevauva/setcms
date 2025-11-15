<?php

declare(strict_types=1);

$routes['GET /~/email/index AdminEmailIndex'] = \Module\Email\Controller\EmailPrivateIndexController::class;
$routes['GET /~/email/read/[g:id] AdminEmailRead'] = \Module\Email\Controller\EmailPrivateReadController::class;
$routes['GET /~/email/new/[g:id] AdminEmailNew'] = \Module\Email\Controller\EmailPrivateNewController::class;
$routes['GET /~/email/edit/[g:id] AdminEmailEdit'] = \Module\Email\Controller\EmailPrivateEditController::class;
$routes['POST /~/email/update/[g:id] AdminEmailUpdate'] = \Module\Email\Controller\EmailPrivateUpdateController::class;
$routes['POST /~/email/create/[g:id] AdminEmailCreate'] = \Module\Email\Controller\EmailPrivateCreateController::class;
