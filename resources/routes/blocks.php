<?php

declare(strict_types=1);

use SetCMS\Module\Block\BlockPublicController;

$routes['block_read_by_section'] = ['GET', '/block/section/[a:section]', BlockPublicController::toRoute()->blocksBySection()];
