<?php

declare(strict_types=1);

namespace Module\Post\Entity;

use SetCMS\Entity\Entity;
use SetCMS\UUID;

class PostEntity extends Entity
{

    public string $slug;
    public string $title;
    public string $message;
    public UUID $createdUserId;
}
