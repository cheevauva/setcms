<?php

use Module\User\UserRoleConstants;

$acl = [];
$acl['rules'][UserRoleConstants::GUEST]['routes'] ??= [];
$acl['rules'][UserRoleConstants::USER]['routes'] ??= [];
$acl['rules'][UserRoleConstants::ADMIN]['routes'] ??= [];

foreach (glob(__DIR__ . '/acl/*.php') ?: [] as $file) {
    require $file;
}

return $acl;
