<?php

$routes['post_read_by_slug'] = ['GET', '/[*:slug]', \SetCMS\Module\Post\PostIndexController::toRoute()->readBySlug()];
