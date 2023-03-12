<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Exception;

class PostAlreadyExistsException extends PostException
{

    public function label(): string
    {
        return 'setcms.post.alreadyexists';
    }

}
