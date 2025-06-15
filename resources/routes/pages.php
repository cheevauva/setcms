<?php

declare(strict_types=1);

use SetCMS\Module\Page\Controller\PagePublicController;

$routes['GET /p-[*:slug] page_read_by_slug'] = \SetCMS\Module\Page\Controller\PagePublicReadBySlugController::class;
$routes['GET /page/block/[a:slug] post_read_block_by_slug'] = PagePublicController::class;
