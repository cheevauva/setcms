<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['roles'][UserRoleConstants::GUEST] = [];
$acl['roles'][UserRoleConstants::USER] = [UserRoleConstants::GUEST];
$acl['roles'][UserRoleConstants::ADMIN] = [UserRoleConstants::USER];
