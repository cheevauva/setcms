<?php

declare(strict_types=1);

namespace Module\Post\View;

use SetCMS\View\ViewJson;
use Module\Post\PostEntity;

class PostPrivateUpdateView extends ViewJson
{

    public ?PostEntity $post = null;
}
