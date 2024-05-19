<?php

$routes['menu_read_by_context'] = ['GET', '/menu/for/context', \SetCMS\Module\Menu\MenuPublicController::toRoute()->readByContext()];
$routes['menu_read_by_slug'] = ['GET', '/menu/for/[a:slug]', \SetCMS\Module\Menu\MenuPublicController::toRoute()->readBySlug()];
