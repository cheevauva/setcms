<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use SetCMS\Common\Entity\Entity;

class PostEntity extends Entity
{

    use \SetCMS\Traits\AsTrait;

    public string $slug;
    public string $title;
    public string $message;
    public string $userId = '1';

}
