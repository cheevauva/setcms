<?php

use SetCMS\Module\User\UserRoleEnum;

return [
    'roles' => [
        'guest' => [],
        'user' => ['guest'],
        'admin' => ['user'],
    ],
    'rules' => [
        'guest' => [
            'scope' => [
                \SetCMS\Module\Captcha\Scope\CaptchaGenerateScope::class => true,
                \SetCMS\Module\Captcha\Scope\CaptchaSolveScope::class => true,
                // User
                \SetCMS\Module\User\Scope\UserPublicLoginScope::class => true,
                \SetCMS\Module\User\Scope\UserPublicDoLoginScope::class => true,
                \SetCMS\Module\User\Scope\UserRegistrationScope::class => true,
                \SetCMS\Module\User\Scope\UserDoRegistrationScope::class => true,
                \SetCMS\Module\User\Scope\UserProfileScope::class => false,
                \SetCMS\Module\User\Scope\UserInfoScope::class => false,
                // Post
                \SetCMS\Module\Post\Scope\PostIndexScope::class => true,
                \SetCMS\Module\Post\Scope\PostReadBySlugScope::class => true,
            ],
        ],
        'user' => [
            'scope' => [
                \SetCMS\Module\User\Scope\UserProfileScope::class => true,
                \SetCMS\Module\User\Scope\UserRegistrationScope::class => false,
                \SetCMS\Module\User\Scope\UserInfoScope::class => true,
                \SetCMS\Module\User\Scope\UserDoRegistrationScope::class => false,
            ],
        ],
        'admin' => [
            'scope' => [
                // page
                \SetCMS\Module\Page\Scope\PagePrivateIndexScope::class => true,
                \SetCMS\Module\Page\Scope\PagePrivateSaveScope::class => true,
                \SetCMS\Module\Page\Scope\PagePrivateEditScope::class => true,
                \SetCMS\Module\Page\Scope\PagePrivateReadScope::class => true,
                // post
                \SetCMS\Module\Post\Scope\PostPrivateIndexScope::class => true,
                \SetCMS\Module\Post\Scope\PostPrivateSaveScope::class => true,
                \SetCMS\Module\Post\Scope\PostPrivateEditScope::class => true,
                \SetCMS\Module\Post\Scope\PostPrivateReadScope::class => true,
                \SetCMS\Module\Post\Scope\PostPrivateUpdateScope::class => true,
                \SetCMS\Module\Post\Scope\PostPrivateCreateScope::class => true,
                // user
                \SetCMS\Module\User\Scope\UserPrivateIndexScope::class => true,
                \SetCMS\Module\User\Scope\UserPrivateEditScope::class => true,
                \SetCMS\Module\User\Scope\UserPrivateSaveScope::class => true,
                \SetCMS\Module\User\Scope\UserPrivateReadScope::class => true,
            ],
        ],
    ],
];
