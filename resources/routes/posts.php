<?php

$routes[] = ['GET', '/[*:slug]', ['action' => 'read', 'module' => 'Posts'], 'post_read_by_slug'];
