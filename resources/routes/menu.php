<?php

declare(strict_types=1);

use SetCMS\Module\Menu\Controller\MenuPublicReadByContextController;
use SetCMS\Module\Menu\Controller\MenuPublicReadBySlugController;
use SetCMS\Module\Menu\Controller\MenuPublicAdminMenuController;

$routes['GET /menu/for/context menu_read_by_context'] = MenuPublicReadByContextController::class;
$routes['GET menu/for/[a:slug] menu_read_by_slug'] = MenuPublicReadBySlugController::class;
$routes['GET /~/menu admin_menu'] = MenuPublicAdminMenuController::class;
