<?php

$routes['post_read_by_slug'] = ['GET', '/[a:slug]', \SetCMS\Module\Post\PostPublicController::toRoute()->readBySlug()];
