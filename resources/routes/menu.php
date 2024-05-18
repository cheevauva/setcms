<?php

$routes['menu_read_by_slug'] = ['GET', '/menu/for/[a:slug]', \SetCMS\Module\Menu\MenuPublicController::toRoute()->readBySlug()];
