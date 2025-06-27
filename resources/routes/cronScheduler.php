<?php

declare(strict_types=1);

$routes['GET /~/cronScheduler/index AdminCronSchedulerIndex'] = \SetCMS\Module\CronScheduler\Controller\CronSchedulerPrivateIndexController::class;
$routes['GET /~/cronScheduler/read/[g:id] AdminCronSchedulerRead'] = \SetCMS\Module\CronScheduler\Controller\CronSchedulerPrivateReadController::class;
$routes['GET /~/cronScheduler/new/[g:id] AdminCronSchedulerNew'] = \SetCMS\Module\CronScheduler\Controller\CronSchedulerPrivateNewController::class;
$routes['GET /~/cronScheduler/edit/[g:id] AdminCronSchedulerEdit'] = \SetCMS\Module\CronScheduler\Controller\CronSchedulerPrivateEditController::class;
$routes['POST /~/cronScheduler/update/[g:id] AdminCronSchedulerUpdate'] = \SetCMS\Module\CronScheduler\Controller\CronSchedulerPrivateUpdateController::class;
$routes['POST /~/cronScheduler/create/[g:id] AdminCronSchedulerCreate'] = \SetCMS\Module\CronScheduler\Controller\CronSchedulerPrivateCreateController::class;
