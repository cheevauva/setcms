<?php

declare(strict_types=1);

$routes['GET /~/email/index AdminEmailIndex'] = \SetCMS\Module\Email\Controller\EmailPrivateIndexController::class;
$routes['GET /~/email/read/[g:id] AdminEmailRead'] = \SetCMS\Module\Email\Controller\EmailPrivateReadController::class;
$routes['GET /~/email/new/[g:id] AdminEmailNew'] = \SetCMS\Module\Email\Controller\EmailPrivateNewController::class;
$routes['GET /~/email/edit/[g:id] AdminEmailEdit'] = \SetCMS\Module\Email\Controller\EmailPrivateEditController::class;
$routes['POST /~/email/update/[g:id] AdminEmailUpdate'] = \SetCMS\Module\Email\Controller\EmailPrivateUpdateController::class;
$routes['POST /~/email/create/[g:id] AdminEmailCreate'] = \SetCMS\Module\Email\Controller\EmailPrivateCreateController::class;
