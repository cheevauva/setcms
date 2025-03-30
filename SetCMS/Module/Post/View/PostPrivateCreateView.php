<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\View;

use SetCMS\Module\Post\PostEntity;

class PostPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?PostEntity $post = null;
}
