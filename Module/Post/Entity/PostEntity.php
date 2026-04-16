<?php

declare(strict_types=1);

namespace Module\Post\Entity;

use SetCMS\Entity\EntityBasic;

class PostEntity extends EntityBasic
{

    public string $slug;
    public string $title;
    public string $message;
}
