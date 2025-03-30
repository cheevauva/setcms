<?php

declare(strict_types=1);

use SetCMS\Module\Block\Controller\BlockPublicController;

$routes['GET /block/section/[a:section] block_read_by_section'] = BlockPublicController::class;
