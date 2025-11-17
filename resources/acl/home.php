<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::GUEST]['routes']['Home'] = true;
//
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminHome'] = true;
