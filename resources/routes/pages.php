<?php

declare(strict_types=1);

$routes['GET /p-[*:slug] page_read_by_slug'] = \SetCMS\Module\Page\Controller\PagePublicReadBySlugController::class;
$routes['SETCMS /page/block/[a:slug] post_read_block_by_slug'] = \SetCMS\Module\Page\Controller\PagePublicReadBlockBySlugController::class;
