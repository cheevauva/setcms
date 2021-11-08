<?php

return [
    'roles' => [
        'guest' => [],
        'user' => ['guest'],
        'admin' => ['user'],
    ],
    'rules' => [
        'guest' => [
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
            ],
            'Blocks' => [],
            'Modules' => [],
        ],
        'user' => [
            'Users' => [
                'UserIndex::profile' => true,
                'UserIndex::registration' => false,
                'UserIndex::userinfo' => true,
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
            'Migrations' => [
                'MigrationAdmin::index' => true,
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
            'Blocks' => [
                'BlockAdmin::index' => true,
                'BlockAdmin::read' => true,
                'BlockAdmin::save' => true,
            ],
            'Modules' => [
                'ModuleAdmin::index' => true,
                'ModuleAdmin::read' => true,
                'ModuleAdmin::save' => true,
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
