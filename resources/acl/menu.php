<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::GUEST]['routes']['menuMain'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['post_read_block_by_slug'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['menuActions'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['menu_read_by_context'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['menuMainSub'] = true;
//
$acl['rules'][UserRoleConstants::ADMIN]['routes']['admin_menu'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuCreate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuNew'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminMenuReadByContext'] = true;
