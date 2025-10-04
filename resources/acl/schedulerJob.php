<?php

declare(strict_types=1);

use SetCMS\Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerJobIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerJobNew'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerJobEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerJobRead'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerJobUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminSchedulerJobCreate'] = true;
