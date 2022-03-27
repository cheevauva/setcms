<?php

declare(strict_types=1);

namespace SetCMS\Core\Entity\Exception;

use SetCMS\Throwable\NotFound;

class EntityNotFoundException extends \Exception implements NotFound
{
    
}
