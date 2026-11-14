<?php

declare(strict_types=1);

namespace Module\Post\View;

use Module\Post\Entity\PostEntity;

class PostPrivateEditView extends PostPrivateReadView
{

    public PostEntity $entity;
}
