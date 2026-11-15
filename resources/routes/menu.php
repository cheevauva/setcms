<?php

declare(strict_types=1);

use Module\Menu\Controller\MenuPublicReadByContextController;
use Module\Menu\Controller\MenuPublicReadBySlugController;
use Module\Menu\Controller\MenuPrivateAdminMenuController;
use Module\Menu\Controller\MenuPublicMainController;
use Module\Menu\Controller\MenuPublicMainSubController;
use Module\Menu\Controller\MenuPublicActionsController;

$routes['GET /menu/for/context MenuReadByContext'] = MenuPublicReadByContextController::class;
$routes['GET /menu/for/main MenuMain'] = MenuPublicMainController::class;
$routes['GET /menu/for/submain MenuMainSub'] = MenuPublicMainSubController::class;
$routes['GET /menu/for/actions MenuActions'] = MenuPublicActionsController::class;
$routes['GET /menu/for/[a:slug] MenuReadBySlug'] = MenuPublicReadBySlugController::class;
$routes['GET /~/menu AdminMenu'] = MenuPrivateAdminMenuController::class;
$routes['GET /~/menu/index AdminMenuIndex'] = \Module\Menu\Controller\MenuPrivateIndexController::class;
$routes['GET /~/menu/new/[g:id] AdminMenuNew'] = \Module\Menu\Controller\MenuPrivateNewController::class;
$routes['POST /~/menu/update/[g:id] AdminMenuUpdate'] = \Module\Menu\Controller\MenuPrivateUpdateController::class;
$routes['POST /~/menu/create/[g:id] AdminMenuCreate'] = \Module\Menu\Controller\MenuPrivateCreateController::class;
$routes['GET /~/menu/read/[g:id] AdminMenuRead'] = \Module\Menu\Controller\MenuPrivateReadController::class;
$routes['GET /~/menu/edit/[g:id] AdminMenuEdit'] = \Module\Menu\Controller\MenuPrivateEditController::class;
