<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Exception;

use SetCMS\Application\Contract\ContractNotFound;

class PostNotFoundException extends PostException implements ContractNotFound
{

    public function label(): string
    {
        return 'setcms.post.notfound';
    }

}
