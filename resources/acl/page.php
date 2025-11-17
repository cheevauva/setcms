<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::GUEST]['routes']['PageReadBlockBySlug'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['PageReadBySlug'] = true;
//
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageCreate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageRead'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageNew'] = true;
