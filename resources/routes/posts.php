<?php

$routes['post_read_by_slug'] = ['GET', '/[a:slug]', \SetCMS\Module\Post\Controller\PostPublicController::toRoute()->readBySlug()];
