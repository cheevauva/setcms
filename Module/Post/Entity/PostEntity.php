<?php

declare(strict_types=1);

namespace Module\Post\Entity;

class PostEntity extends \Module\Basic\Entity\BasicEntity
{

    public string $slug;
    public string $title;
    public string $message;
}
