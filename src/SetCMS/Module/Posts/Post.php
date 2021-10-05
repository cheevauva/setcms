<?php

namespace SetCMS\Module\Posts;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class Post extends OrdinaryEntity
{
    public string $module = 'Posts';
    public string $slug;
    public string $title = '';
    public string $message = '';

}
