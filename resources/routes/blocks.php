<?php

declare(strict_types=1);

use SetCMS\Module\Block\Controller\BlockPublicController;

$routes['block_read_by_section'] = BlockPublicController::toRoute('GET', '/block/section/[a:section]')->blocksBySection();
