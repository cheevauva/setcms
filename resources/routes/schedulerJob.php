<?php

declare(strict_types=1);

$routes['GET /~/schedulerJob/index AdminSchedulerJobIndex'] = \Module\SchedulerJob\Controller\SchedulerJobPrivateIndexController::class;
$routes['GET /~/schedulerJob/read/[g:id] AdminSchedulerJobRead'] = \Module\SchedulerJob\Controller\SchedulerJobPrivateReadController::class;
$routes['GET /~/schedulerJob/new/[g:id] AdminSchedulerJobNew'] = \Module\SchedulerJob\Controller\SchedulerJobPrivateNewController::class;
$routes['GET /~/schedulerJob/edit/[g:id] AdminSchedulerJobEdit'] = \Module\SchedulerJob\Controller\SchedulerJobPrivateEditController::class;
$routes['POST /~/schedulerJob/update/[g:id] AdminSchedulerJobUpdate'] = \Module\SchedulerJob\Controller\SchedulerJobPrivateUpdateController::class;
$routes['POST /~/schedulerJob/create/[g:id] AdminSchedulerJobCreate'] = \Module\SchedulerJob\Controller\SchedulerJobPrivateCreateController::class;
