<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::GUEST]['routes']['PostIndex'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['PostReadBySlug'] = true;
//
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPostIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPostEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPostRead'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPostNew'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPostUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPostCreate'] = true;
