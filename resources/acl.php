<?php

use SetCMS\Module\User\UserRoleConstants;

$acl = [
    'roles' => [
        UserRoleConstants::GUEST => [],
        UserRoleConstants::USER => [
            UserRoleConstants::GUEST
        ],
        UserRoleConstants::ADMIN => [
            UserRoleConstants::USER
        ],
    ],
    'rules' => [
        UserRoleConstants::GUEST => [
            'routes' => [
                'Home' => true,
                'CaptchaGenerate' => true,
                'CaptchaSolve' => true,
                // User
                'UserLogin' => true,
                'UserDoLogin' => true,
                'UserRegistration' => true,
                'UserDoRegistration' => true,
                'UserProfile' => false,
                'UserUserInfo' => false,
                'UserRestore' => true,
                'UserDoRestore' => true,
                'UserResetPasswordByToken' => true,
                // Post
                'PostroutesIndex' => true,
                'PostReadBySlug' => true,
                // Page
                'PageReadBlockBySlug' => true,
                'PageReadBySlug' => true,
            ],
        ],
        UserRoleConstants::USER => [
            'routes' => [
                'UserProfile' => true,
                'UserRegistration' => false,
                'UserUserInfo' => true,
                'UserDoRegistration' => false,
                'UserLogout' => true,
                'UserLogin' => false,
                'UserDoLogin' => false,
                'UserRestore' => false,
                'UserDoRestore' => false,
                'UserResetPassword' => false,
            ],
        ],
        UserRoleConstants::ADMIN => [
            'routes' => [
                'AdminHome' => true,
                //page
                'AdminPageNew' => true,
                'AdminPageCreate' => true,
                //post
                'AdminPostNew' => true,
                // user
                'AdminUserIndex' => true,
                'AdminUserEdit' => true,
                'AdminUserUpdate' => true,
                'AdminUserRead' => true,
                //
                'ConfigurationAdminMenu' => true,
                'ConfigurationMain' => true,
                //
                'AdminMenuIndex' => true,
                'AdminMenuEdit' => true,
                'AdminMenuCreate' => true,
                'AdminMenuNew' => true,
                'AdminMenuUpdate' => true,
                'AdminMenuReadByContext' => true,
            ],
        ],
    ],
];

foreach (glob(__DIR__ . '/acl/*.php') ?: [] as $file) {
    require_once $file;
}

return $acl;
