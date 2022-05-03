<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use SetCMS\Entity;

class PostEntity extends Entity
{

    public string $slug;
    public string $title;
    public string $message;
    public string $userId = '1';

}
