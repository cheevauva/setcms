<?php

declare(strict_types=1);

$routes['GET /~/schedulerJob/index AdminSchedulerJobIndex'] = \SetCMS\Module\SchedulerJob\Controller\SchedulerJobPrivateIndexController::class;
$routes['GET /~/schedulerJob/read/[g:id] AdminSchedulerJobRead'] = \SetCMS\Module\SchedulerJob\Controller\SchedulerJobPrivateReadController::class;
$routes['GET /~/schedulerJob/new/[g:id] AdminSchedulerJobNew'] = \SetCMS\Module\SchedulerJob\Controller\SchedulerJobPrivateNewController::class;
$routes['GET /~/schedulerJob/edit/[g:id] AdminSchedulerJobEdit'] = \SetCMS\Module\SchedulerJob\Controller\SchedulerJobPrivateEditController::class;
$routes['POST /~/schedulerJob/update/[g:id] AdminSchedulerJobUpdate'] = \SetCMS\Module\SchedulerJob\Controller\SchedulerJobPrivateUpdateController::class;
$routes['POST /~/schedulerJob/create/[g:id] AdminSchedulerJobCreate'] = \SetCMS\Module\SchedulerJob\Controller\SchedulerJobPrivateCreateController::class;
