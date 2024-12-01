<?php

$routes['post_read_block_by_slug'] = ['GET', '/page/block/[a:slug]', \SetCMS\Module\Page\Controller\PagePublicController::toRoute()->block()];
