<?php

use SetCMS\Module\User\Enum\UserRoleEnum;

$acl = [
    'roles' => [
        UserRoleEnum::GUEST->toString() => [],
        UserRoleEnum::USER->toString() => [
            UserRoleEnum::GUEST->toString()
        ],
        UserRoleEnum::ADMIN->toString() => [
            UserRoleEnum::USER->toString()
        ],
    ],
    'rules' => [
        UserRoleEnum::GUEST->toString() => [
            'scope' => [
                \SetCMS\Module\Captcha\Scope\CaptchaPublicGenerateScope::class => true,
                \SetCMS\Module\Captcha\Scope\CaptchaPublicSolveScope::class => true,
                // User
                \SetCMS\Module\User\Scope\UserPublicLoginScope::class => true,
                \SetCMS\Module\User\Scope\UserPublicDoLoginScope::class => true,
                \SetCMS\Module\User\Scope\UserPublicRegistrationScope::class => true,
                \SetCMS\Module\User\Scope\UserPublicDoRegistrationScope::class => true,
                \SetCMS\Module\User\Scope\UserPublicProfileScope::class => false,
                \SetCMS\Module\User\Scope\UserInfoScope::class => false,
                // Post
                \SetCMS\Module\Post\Scope\PostPublicIndexScope::class => true,
                \SetCMS\Module\Post\Scope\PostPublicReadBySlugScope::class => true,
                // Page
                \SetCMS\Module\Page\Scope\PagePublicReadScope::class => true,
                \SetCMS\Module\Page\Scope\PagePublicReadBlockScope::class => true,
            ],
        ],
        UserRoleEnum::USER->toString() => [
            'scope' => [
                \SetCMS\Module\User\Scope\UserPublicProfileScope::class => true,
                \SetCMS\Module\User\Scope\UserPublicRegistrationScope::class => false,
                \SetCMS\Module\User\Scope\UserInfoScope::class => true,
                \SetCMS\Module\User\Scope\UserPublicDoRegistrationScope::class => false,
                \SetCMS\Module\User\Scope\UserPublicLogoutScope::class => true,
                \SetCMS\Module\User\Scope\UserPublicLoginScope::class => false,
                \SetCMS\Module\User\Scope\UserPublicDoLoginScope::class => false,
            ],
        ],
        UserRoleEnum::ADMIN->toString() => [
            'scope' => [
                // user
                \SetCMS\Module\User\Scope\UserPrivateIndexScope::class => true,
                \SetCMS\Module\User\Scope\UserPrivateEditScope::class => true,
                \SetCMS\Module\User\Scope\UserPrivateUpdateScope::class => true,
                \SetCMS\Module\User\Scope\UserPrivateReadScope::class => true,
                // block
                \SetCMS\Module\Block\Scope\BlockPrivateIndexScope::class => true,
                \SetCMS\Module\Block\Scope\BlockPrivateEditScope::class => true,
                \SetCMS\Module\Block\Scope\BlockPrivateSaveScope::class => true,
                \SetCMS\Module\Block\Scope\BlockPrivateReadScope::class => true,
                \SetCMS\Module\Block\Scope\BlockPrivateCreateScope::class => true,
                \SetCMS\Module\Block\Scope\BlockPrivateUpdateScope::class => true,
                \SetCMS\Module\Block\Scope\BlockPublicSectionScope::class => true,
                //
                \SetCMS\Module\Configuration\Scope\ConfigurationPublicAdminMenuScope::class => true,
                \SetCMS\Module\Configuration\Scope\ConfigurationPublicMainScope::class => true,
                //
                \SetCMS\Module\Menu\Scope\MenuPrivateIndexScope::class => true,
                \SetCMS\Module\Menu\Scope\MenuPrivateEditScope::class => true,
                \SetCMS\Module\Menu\Scope\MenuPrivateCreateScope::class => true,
                \SetCMS\Module\Menu\Scope\MenuPublicReadByContextScope::class => true,
            ],
        ],
    ],
];

foreach (glob(__DIR__ . '/acl/*.php') as $file) {
    require_once $file;
}

return $acl;