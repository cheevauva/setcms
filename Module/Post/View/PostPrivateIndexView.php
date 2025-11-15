<?php

declare(strict_types=1);

namespace Module\Post\View;

use SetCMS\View\ViewTwig;
use SetCMS\View\ViewJson;

class PostPrivateIndexView extends ViewTwig
{

    /**
     * @var \Module\Post\PostEntity[]
     */
    public array $posts = [];
}
