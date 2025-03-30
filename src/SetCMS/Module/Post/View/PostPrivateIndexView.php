<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\View;

use SetCMS\View\ViewTwig;
use SetCMS\View\ViewJson;

class PostPrivateIndexView extends ViewTwig
{

    /**
     * @var \SetCMS\Module\Post\PostEntity[]
     */
    public array $entities = [];
}
