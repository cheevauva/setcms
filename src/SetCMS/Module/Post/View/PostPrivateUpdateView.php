<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\View;

use SetCMS\View\ViewJson;
use SetCMS\Module\Post\PostEntity;

class PostPrivateUpdateView extends ViewJson
{

    public ?PostEntity $post = null;
}
