<?php

use Module\SchedulerJob\Servant\SchedulerJobRunServant;
use SetCMS\UUID;

$container = require_once '../bootstrap.php';

$run = SchedulerJobRunServant::new($container);
$run->cronSchedulerId = new UUID($argv[1] ?? '!!!');
$run->serve();

