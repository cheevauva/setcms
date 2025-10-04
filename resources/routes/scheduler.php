<?php

declare(strict_types=1);

$routes['GET /~/scheduler/index AdminSchedulerIndex'] = \SetCMS\Module\Scheduler\Controller\SchedulerPrivateIndexController::class;
$routes['GET /~/scheduler/read/[g:id] AdminSchedulerRead'] = \SetCMS\Module\Scheduler\Controller\SchedulerPrivateReadController::class;
$routes['GET /~/scheduler/new/[g:id] AdminSchedulerNew'] = \SetCMS\Module\Scheduler\Controller\SchedulerPrivateNewController::class;
$routes['GET /~/scheduler/edit/[g:id] AdminSchedulerEdit'] = \SetCMS\Module\Scheduler\Controller\SchedulerPrivateEditController::class;
$routes['POST /~/scheduler/update/[g:id] AdminSchedulerUpdate'] = \SetCMS\Module\Scheduler\Controller\SchedulerPrivateUpdateController::class;
$routes['POST /~/scheduler/create/[g:id] AdminSchedulerCreate'] = \SetCMS\Module\Scheduler\Controller\SchedulerPrivateCreateController::class;
$routes['SETCMS /~/scheduler/jobs AdminSchedulerJobs'] = \SetCMS\Module\Scheduler\Controller\SchedulerPrivateJobsController::class;
