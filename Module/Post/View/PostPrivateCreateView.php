<?php

declare(strict_types=1);

namespace Module\Post\View;

use Module\Post\Entity\PostEntity;

class PostPrivateCreateView extends \SetCMS\View\ViewJson
{

    public ?PostEntity $entity = null;
}
