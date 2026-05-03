<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::ADMIN]['routes']['ConfigurationAdminMenu'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['ConfigurationMain'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['configurations_main'] = true;
