<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Exception;

use SetCMS\Exception;

class PostException extends Exception
{

    public function label(): string
    {
        return 'setcms.post.label';
    }

}
