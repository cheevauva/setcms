<?php

declare(strict_types=1);

use SetCMS\Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::GUEST]['routes']['MigrationUp'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['MigrationDoUp'] = true;
