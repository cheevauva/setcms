<?php

declare(strict_types=1);

use SetCMS\Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerWorkIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerWorkNew'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerWorkEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerWorkRead'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerWorkUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerWorkCreate'] = true;
