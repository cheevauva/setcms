<?php

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
                \SetCMS\Module\User\Scope\UserRegistrationScope::class => true,
                \SetCMS\Module\User\Scope\UserDoRegistrationScope::class => true,
                \SetCMS\Module\User\Scope\UserProfileScope::class => false,
                \SetCMS\Module\User\Scope\UserInfoScope::class => false,
                \SetCMS\Module\Post\Scope\PostIndexScope::class => true,
                \SetCMS\Module\Post\Scope\PostReadBySlugScope::class => true,
            ],
            'Captcha' => [
                'CaptchaIndex::generate' => true,
                'CaptchaIndex::solve' => true,
            ],
            'Users' => [
                'UserIndex::registration' => true,
                'UserIndex::doRegistration' => true,
            ],
            'OAuth' => [
                'OAuthIndex::code' => true,
                'OAuthIndex::login' => true,
                'OAuthIndex::authorize' => true,
                'OAuthIndex::doAuthorize' => true,
                'OAuthIndex::callback' => true,
                'OAuthIndex::token' => true,
            ],
            'Posts' => [
                'PostIndex::index' => true,
                'PostIndex::read' => true,
                'PostIndex::readBySlug' => true,
                'PostIndex::save' => true,
            ],
            'Blocks' => [],
            'Modules' => [],
        ],
        'user' => [
            'scope' => [
                \SetCMS\Module\User\Scope\UserProfileScope::class => true,
                \SetCMS\Module\User\Scope\UserRegistrationScope::class => false,
                \SetCMS\Module\User\Scope\UserInfoScope::class => true,
                \SetCMS\Module\User\Scope\UserDoRegistrationScope::class => false,
            ],
            'OAuth' => [
                'OAuthIndex::logout' => true,
            ],
            'post' => [
                'read' => true,
                'index' => true,
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
                // user
                \SetCMS\Module\User\Scope\UserPrivateIndexScope::class => true,
                \SetCMS\Module\User\Scope\UserPrivateEditScope::class => true,
                \SetCMS\Module\User\Scope\UserPrivateSaveScope::class => true,
                \SetCMS\Module\User\Scope\UserPrivateReadScope::class => true,
            ],
            'Users' => [
                'UserAdmin::index' => true,
                'UserAdmin::save' => true,
            ],
            'OAuthClients' => [
                'OAuthClientAdmin::index' => true,
                'OAuthClientAdmin::read' => true,
                'OAuthClientAdmin::save' => true,
            ],
            'Posts' => [
                'PostAdmin::index' => true,
                'PostAdmin::read' => true,
                'PostAdmin::save' => true,
            ],
            'Pages' => [
                'PageAdmin::index' => true,
                'PageAdmin::read' => true,
                'PageAdmin::save' => true,
            ],
            'oauthclient' => [
                'create' => true,
                'update' => true,
            ],
            'user' => [
                'update' => true,
            ],
            'page' => [
                'update' => true,
                'create' => true,
            ],
            'block' => [
                'update' => true,
                'create' => true,
            ],
            'post' => [
                'create' => true,
                'read' => true,
                'delete' => true,
                'update' => true,
                'index' => true,
            ],
        ],
    ],
];
