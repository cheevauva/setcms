<?php

declare(strict_types=1);

$routes['GET /p-[*:slug] page_read_by_slug'] = \SetCMS\Module\Page\Controller\PagePublicReadBySlugController::class;
$routes['SETCMS /page/block/[a:slug] post_read_block_by_slug'] = \SetCMS\Module\Page\Controller\PagePublicReadBlockBySlugController::class;
$routes['GET /~/page/index AdminPageIndex'] = \SetCMS\Module\Page\Controller\PagePrivateIndexController::class;
$routes['GET /~/page/read/[g:id] AdminPageRead'] = \SetCMS\Module\Page\Controller\PagePrivateReadController::class;
$routes['GET /~/page/new/[g:id] AdminPageNew'] = \SetCMS\Module\Page\Controller\PagePrivateNewController::class;
$routes['GET /~/page/edit/[g:id] AdminPageEdit'] = \SetCMS\Module\Page\Controller\PagePrivateEditController::class;
$routes['POST /~/page/update/[g:id] AdminPageUpdate'] = \SetCMS\Module\Page\Controller\PagePrivateUpdateController::class;
$routes['POST /~/page/create/[g:id] AdminPageCreate'] = \SetCMS\Module\Page\Controller\PagePrivateCreateController::class;

