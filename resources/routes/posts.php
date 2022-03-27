<?php

$routes['post_read_by_slug'] = ['GET', '/[*:slug]', ['action' => 'readBySlug', 'module' => 'Post', 'section' => 'Index']];
