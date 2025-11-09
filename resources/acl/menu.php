<?php

declare(strict_types=1);

use SetCMS\Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::GUEST]['routes']['menuMain'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['post_read_block_by_slug'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['menuActions'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['menu_read_by_context'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['menuMainSub'] = true;
//
$acl['rules'][UserRoleConstants::ADMIN]['routes']['admin_menu'] = true;


