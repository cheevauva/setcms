<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\Post\PostEntity;

class PostPrivateReadView extends ViewTwig
{

    public PostEntity $post;
}
