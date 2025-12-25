<?php

declare(strict_types=1);

$routes['GET /~/scheduler/index AdminSchedulerIndex'] = \Module\Scheduler\Controller\SchedulerPrivateIndexController::class;
$routes['GET /~/scheduler/read/[g:id] AdminSchedulerRead'] = \Module\Scheduler\Controller\SchedulerPrivateReadController::class;
$routes['GET /~/scheduler/new/[g:id] AdminSchedulerNew'] = \Module\Scheduler\Controller\SchedulerPrivateNewController::class;
$routes['GET /~/scheduler/edit/[g:id] AdminSchedulerEdit'] = \Module\Scheduler\Controller\SchedulerPrivateEditController::class;
$routes['POST /~/scheduler/update/[g:id] AdminSchedulerUpdate'] = \Module\Scheduler\Controller\SchedulerPrivateUpdateController::class;
$routes['POST /~/scheduler/create/[g:id] AdminSchedulerCreate'] = \Module\Scheduler\Controller\SchedulerPrivateCreateController::class;
$routes['SETCMS /~/scheduler/jobs AdminSchedulerJobs'] = \Module\Scheduler\Controller\SchedulerPrivateJobsController::class;
