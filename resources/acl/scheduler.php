<?php

declare(strict_types=1);

use SetCMS\Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerNew'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerRead'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerCreate'] = true;
