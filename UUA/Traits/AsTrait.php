<?php

declare(strict_types=1);

namespace UUA\Traits;

trait AsTrait
{

    public static function as(?object $self): static
    {
        if (is_null($self)) {
            throw new \Exception(sprintf('Ожидался %s, а пришел null. Вызывал %s (%s)', static::class, debug_backtrace(2)[0]['file'], debug_backtrace(2)[0]['line']));
        }

        if (!($self instanceof static)) {
            throw new \Exception(sprintf('Ожидался %s, а пришел %s', static::class, get_class($self)));
        }

        return $self;
    }

    public static function is(?object $self): bool
    {
        return $self instanceof static;
    }
}
