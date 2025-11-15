<?php

declare(strict_types=1);

$routes['GET /page-[*:slug] PageReadBySlug'] = \Module\Page\Controller\PagePublicReadBySlugController::class;
$routes['GET /~/page/index AdminPageIndex'] = \Module\Page\Controller\PagePrivateIndexController::class;
$routes['GET /~/page/read/[g:id] AdminPageRead'] = \Module\Page\Controller\PagePrivateReadController::class;
$routes['GET /~/page/new/[g:id] AdminPageNew'] = \Module\Page\Controller\PagePrivateNewController::class;
$routes['GET /~/page/edit/[g:id] AdminPageEdit'] = \Module\Page\Controller\PagePrivateEditController::class;
$routes['POST /~/page/update/[g:id] AdminPageUpdate'] = \Module\Page\Controller\PagePrivateUpdateController::class;
$routes['POST /~/page/create/[g:id] AdminPageCreate'] = \Module\Page\Controller\PagePrivateCreateController::class;
$routes['SETCMS /page/block/[a:slug] post_read_block_by_slug'] = \Module\Page\Controller\PagePublicReadBlockBySlugController::class;

