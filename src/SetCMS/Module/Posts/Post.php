<?php

namespace SetCMS\Module\Posts;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class Post extends OrdinaryEntity
{

    public string $slug;
    public string $title = '';
    public string $message = '';
    public string $userId = '1';

}
