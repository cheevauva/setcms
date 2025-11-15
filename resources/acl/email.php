<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminEmailIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminEmailNew'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminEmailEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminEmailRead'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminEmailUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminEmailCreate'] = true;
