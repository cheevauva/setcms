<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Exception;

use SetCMS\Contract\NotFound;

class PostNotFoundException extends PostException implements NotFound
{

    public function label(): string
    {
        return 'setcms.post.notfound';
    }

}
