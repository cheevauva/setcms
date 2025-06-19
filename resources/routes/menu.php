<?php

declare(strict_types=1);

use SetCMS\Module\Menu\Controller\MenuPublicReadByContextController;
use SetCMS\Module\Menu\Controller\MenuPublicReadBySlugController;
use SetCMS\Module\Menu\Controller\MenuPrivateAdminMenuController;
use SetCMS\Module\Menu\Controller\MenuPublicMainController;
use SetCMS\Module\Menu\Controller\MenuPublicMainSubController;
use SetCMS\Module\Menu\Controller\MenuPublicActionsController;

$routes['SETCMS /menu/for/context menu_read_by_context'] = MenuPublicReadByContextController::class;
$routes['SETCMS /menu/for/main menuMain'] = MenuPublicMainController::class;
$routes['SETCMS /menu/for/submain menuMainSub'] = MenuPublicMainSubController::class;
$routes['SETCMS /menu/for/actions menuActions'] = MenuPublicActionsController::class;
$routes['SETCMS /menu/for/[a:slug] menu_read_by_slug'] = MenuPublicReadBySlugController::class;
$routes['SETCMS /~/menu admin_menu'] = MenuPrivateAdminMenuController::class;
