<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminRAD01Index'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminRAD01New'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminRAD01Edit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminRAD01Delete'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminRAD01Read'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminRAD01Update'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminRAD01Create'] = true;
