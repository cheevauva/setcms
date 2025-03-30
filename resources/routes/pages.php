<?php

declare(strict_types=1);

use SetCMS\Module\Page\Controller\PagePublicController;

$routes['GET /page/block/[a:slug] post_read_block_by_slug'] = PagePublicController::class;
