<?php

declare(strict_types=1);

namespace Module\Post\View;

use SetCMS\View\ViewTwig;

class PostPublicIndexView extends ViewTwig
{

    /**
     * @var \Module\Post\PostEntity[]
     */
    public array $posts = [];
}
