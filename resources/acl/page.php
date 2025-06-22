<?php

declare(strict_types=1);

use SetCMS\Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageCreate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminPageRead'] = true;
