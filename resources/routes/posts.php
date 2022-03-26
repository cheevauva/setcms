<?php

$routes[] = ['GET', '/[*:slug]', ['action' => 'readBySlug', 'module' => 'Post', 'section' => 'Index'], 'post_read_by_slug'];
