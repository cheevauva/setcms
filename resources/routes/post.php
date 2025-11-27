<?php

declare(strict_types=1);

$routes['GET /post-[a:slug] PostReadBySlug'] = \Module\Post\Controller\PostPublicReadBySlugController::class;
$routes['GET /~/post/index AdminPostIndex'] = \Module\Post\Controller\PostPrivateIndexController::class;
$routes['GET /~/post/read/[g:id] AdminPostRead'] = \Module\Post\Controller\PostPrivateReadController::class;
$routes['GET /~/post/new/[g:id] AdminPostNew'] = \Module\Post\Controller\PostPrivateNewController::class;
$routes['GET /~/post/edit/[g:id] AdminPostEdit'] = \Module\Post\Controller\PostPrivateEditController::class;
$routes['POST /~/post/update/[g:id] AdminPostUpdate'] = \Module\Post\Controller\PostPrivateUpdateController::class;
$routes['POST /~/post/create/[g:id] AdminPostCreate'] = \Module\Post\Controller\PostPrivateCreateController::class;
