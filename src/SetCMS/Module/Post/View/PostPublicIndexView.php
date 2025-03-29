<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\View;

use SetCMS\View\ViewTwig;

class PostPublicIndexView extends ViewTwig
{

    /**
     * @var \SetCMS\Module\Post\PostEntity[]
     */
    public array $entities = [];
}
