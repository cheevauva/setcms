<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::GUEST]['routes']['MenuMain'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['MenuActions'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['MenuReadByContext'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['MenuMainSub'] = true;
//
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenu'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuRead'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuCreate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuNew'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuReadByContext'] = true;
