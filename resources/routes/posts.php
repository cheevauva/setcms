<?php

declare(strict_types=1);

$routes['GET /post-[a:slug] post_read_by_slug'] = \SetCMS\Module\Post\Controller\PostPublicReadBySlugController::class;
$routes['GET /~/post/index AdminPostIndex'] = \SetCMS\Module\Post\Controller\PostPrivateIndexController::class;
$routes['GET /~/post/read/[g:id] AdminPostRead'] = \SetCMS\Module\Post\Controller\PostPrivateReadController::class;
$routes['GET /~/post/new/[g:id] AdminPostNew'] = \SetCMS\Module\Post\Controller\PostPrivateNewController::class;
$routes['GET /~/post/edit/[g:id] AdminPostEdit'] = \SetCMS\Module\Post\Controller\PostPrivateEditController::class;
$routes['POST /~/post/update/[g:id] AdminPostUpdate'] = \SetCMS\Module\Post\Controller\PostPrivateUpdateController::class;
$routes['POST /~/post/create/[g:id] AdminPostCreate'] = \SetCMS\Module\Post\Controller\PostPrivateCreateController::class;
