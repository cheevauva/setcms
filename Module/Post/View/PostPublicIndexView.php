<?php

declare(strict_types=1);

namespace Module\Post\View;

use SetCMS\View\ViewTwig;
use Module\Post\Entity\PostEntity;

class PostPublicIndexView extends ViewTwig
{

    /**
     * @var array<PostEntity>
     */
    public array $posts = [];
}
