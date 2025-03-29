<?php

declare(strict_types=1);

use SetCMS\Module\Menu\Controller\MenuPublicReadByContextController;
use SetCMS\Module\Menu\Controller\MenuPublicReadBySlugController;
use SetCMS\Module\Menu\Controller\MenuPublicAdminMenuController;

$routes['INTERNAL /menu/for/context menu_read_by_context'] = MenuPublicReadByContextController::class;
$routes['INTERNAL /menu/for/[a:slug] menu_read_by_slug'] = MenuPublicReadBySlugController::class;
$routes['INTERNAL /~/menu admin_menu'] = MenuPublicAdminMenuController::class;
