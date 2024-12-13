<?php

declare(strict_types=1);

use SetCMS\Module\Menu\Controller\MenuPublicController;
use SetCMS\Module\Menu\Controller\MenuPrivateController;

$routes['menu_read_by_context'] = MenuPublicController::toRoute('GET', '/menu/for/context')->readByContext();
$routes['menu_read_by_slug'] = MenuPublicController::toRoute('GET', '/menu/for/[a:slug]')->readBySlug();
$routes['admin_menu'] = MenuPrivateController::toRoute('GET', '/~/menu')->adminMemu();
