<?php

declare(strict_types=1);

use SetCMS\Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerNew'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerRead'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminCronSchedulerCreate'] = true;
