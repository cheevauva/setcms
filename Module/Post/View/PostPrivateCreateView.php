<?php

declare(strict_types=1);

namespace Module\Post\View;

use Module\Post\PostEntity;

class PostPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?PostEntity $post = null;
}
