<?php

declare(strict_types=1);

use SetCMS\Module\Page\Controller\PagePublicController;

$routes['post_read_block_by_slug'] = PagePublicController::toRoute('GET', '/page/block/[a:slug]')->block();
