<?php

declare(strict_types=1);

use SetCMS\Module\Post\Controller\PostPublicController;

$routes['post_read_by_slug'] = PostPublicController::toRoute('GET', '/[a:slug]')->readBySlug();
