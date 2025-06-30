<?php

declare(strict_types=1);

$routes['GET /~/cronSchedulerWork/index AdminCronSchedulerWorkIndex'] = \SetCMS\Module\CronSchedulerWork\Controller\CronSchedulerWorkPrivateIndexController::class;
$routes['GET /~/cronSchedulerWork/read/[g:id] AdminCronSchedulerWorkRead'] = \SetCMS\Module\CronSchedulerWork\Controller\CronSchedulerWorkPrivateReadController::class;
$routes['GET /~/cronSchedulerWork/new/[g:id] AdminCronSchedulerWorkNew'] = \SetCMS\Module\CronSchedulerWork\Controller\CronSchedulerWorkPrivateNewController::class;
$routes['GET /~/cronSchedulerWork/edit/[g:id] AdminCronSchedulerWorkEdit'] = \SetCMS\Module\CronSchedulerWork\Controller\CronSchedulerWorkPrivateEditController::class;
$routes['POST /~/cronSchedulerWork/update/[g:id] AdminCronSchedulerWorkUpdate'] = \SetCMS\Module\CronSchedulerWork\Controller\CronSchedulerWorkPrivateUpdateController::class;
$routes['POST /~/cronSchedulerWork/create/[g:id] AdminCronSchedulerWorkCreate'] = \SetCMS\Module\CronSchedulerWork\Controller\CronSchedulerWorkPrivateCreateController::class;
