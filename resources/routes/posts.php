<?php

$routes[] = ['GET', '/[*:slug]', ['action' => 'readBySlug', 'module' => 'Posts'], 'post_read_by_slug'];
