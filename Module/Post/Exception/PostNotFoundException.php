<?php

declare(strict_types=1);

namespace Module\Post\Exception;

use SetCMS\Application\Contract\ContractNotFound;

class PostNotFoundException extends PostException implements ContractNotFound
{
    
}
