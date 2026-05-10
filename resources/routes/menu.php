<?php

declare(strict_types=1);

use Module\Menu\Controller\MenuPublicReadByContextController;
use Module\Menu\Controller\MenuPublicReadBySlugController;
use Module\Menu\Controller\MenuPrivateAdminMenuController;
use Module\Menu\Controller\MenuPublicMainController;
use Module\Menu\Controller\MenuPublicMainSubController;
use Module\Menu\Controller\MenuPublicActionsController;

$routes['SETCMS /menu/for/context menu_read_by_context'] = MenuPublicReadByContextController::class;
$routes['SETCMS /menu/for/main menuMain'] = MenuPublicMainController::class;
$routes['SETCMS /menu/for/submain menuMainSub'] = MenuPublicMainSubController::class;
$routes['SETCMS /menu/for/actions menuActions'] = MenuPublicActionsController::class;
$routes['SETCMS /menu/for/[a:slug] menu_read_by_slug'] = MenuPublicReadBySlugController::class;
$routes['SETCMS /~/menu admin_menu'] = MenuPrivateAdminMenuController::class;
$routes['GET /~/menu/index AdminMenuIndex'] = \Module\Menu\Controller\MenuPrivateIndexController::class;
$routes['GET /~/menu/new/[g:id] AdminMenuNew'] = \Module\Menu\Controller\MenuPrivateNewController::class;
$routes['POST /~/menu/update/[g:id] AdminMenuUpdate'] = \Module\Menu\Controller\MenuPrivateUpdateController::class;
$routes['POST /~/menu/create/[g:id] AdminMenuCreate'] = \Module\Menu\Controller\MenuPrivateCreateController::class;
$routes['GET /~/menu/read/[g:id] AdminMenuRead'] = \Module\Menu\Controller\MenuPrivateReadController::class;
$routes['GET /~/menu/edit/[g:id] AdminMenuEdit'] = \Module\Menu\Controller\MenuPrivateEditController::class;
