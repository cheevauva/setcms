<?php

declare(strict_types=1);

namespace UUA\Traits;

trait AsTrait
{

    public static function as(?object $self): static
    {
        if (is_null($self)) {
            throw new \Exception(sprintf('Ожидался %s, а пришел null', static::class));
        }

        if (!($self instanceof static)) {
            throw new \Exception(sprintf('Ожидался %s, а пришел %s', static::class, get_class($self)));
        }

        return $self;
    }
}
