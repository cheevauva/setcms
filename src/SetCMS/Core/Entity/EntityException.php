<?php

declare(strict_types=1);

namespace SetCMS\Core\Entity;

class EntityException extends \Exception
{

    public static function notFound(): self
    {
        return new static('not found');
    }

}
