<?php

return [
    'roles' => [
        'guest' => [],
        'user' => ['guest'],
        'admin' => ['user'],
    ],
    'rules' => [
        'guest' => [
            'Users' => [
                'UserIndex::userinfo' => true,
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
            ],
            'post' => [
                'create' => false,
                'read' => false,
                'delete' => false,
                'update' => false,
                'index' => false,
            ],
        ],
        'user' => [
            'OAuth' => [
                'OAuthIndex::logout' => true,
            ],
            'post' => [
                'create' => false,
                'read' => true,
                'delete' => false,
                'update' => false,
                'index' => true,
            ],
        ],
        'admin' => [
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
