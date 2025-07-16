<?php

use SetCMS\Module\CronSchedulerWork\Servant\CronSchedulerWorkRunServant;
use SetCMS\UUID;

$container = require_once '../bootstrap.php';

$run = CronSchedulerWorkRunServant::new($container);
$run->cronSchedulerId = new UUID($argv[1] ?? '!!!');
$run->serve();

