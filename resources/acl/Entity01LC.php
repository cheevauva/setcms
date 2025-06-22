<?php

declare(strict_types=1);

use SetCMS\Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminModule01Index'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminModule01New'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminModule01Edit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminModule01Read'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminModule01Update'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminModule01Create'] = true;
