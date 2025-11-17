<?php

declare(strict_types=1);

use Module\User\UserRoleConstants;

$acl['rules'][UserRoleConstants::GUEST]['routes']['UserLogin'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['UserDoLogin'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['UserRegistration'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['UserDoRegistration'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['UserProfile'] = false;
$acl['rules'][UserRoleConstants::GUEST]['routes']['UserUserInfo'] = false;
$acl['rules'][UserRoleConstants::GUEST]['routes']['UserRestore'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['UserDoRestore'] = true;
$acl['rules'][UserRoleConstants::GUEST]['routes']['UserResetPasswordByToken'] = true;
//
$acl['rules'][UserRoleConstants::USER]['routes']['UserProfile'] = true;
$acl['rules'][UserRoleConstants::USER]['routes']['UserRegistration'] = false;
$acl['rules'][UserRoleConstants::USER]['routes']['UserUserInfo'] = true;
$acl['rules'][UserRoleConstants::USER]['routes']['UserDoRegistration'] = false;
$acl['rules'][UserRoleConstants::USER]['routes']['UserLogout'] = true;
$acl['rules'][UserRoleConstants::USER]['routes']['UserLogin'] = false;
$acl['rules'][UserRoleConstants::USER]['routes']['UserDoLogin'] = false;
$acl['rules'][UserRoleConstants::USER]['routes']['UserRestore'] = false;
$acl['rules'][UserRoleConstants::USER]['routes']['UserDoRestore'] = false;
$acl['rules'][UserRoleConstants::USER]['routes']['UserResetPassword'] = false;
//
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminUserIndex'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminUserEdit'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminUserUpdate'] = true;
$acl['rules'][UserRoleConstants::ADMIN]['routes']['AdminUserRead'] = true;
