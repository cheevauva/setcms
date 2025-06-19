<?php

declare(strict_types=1);

namespace UUA\Traits;

trait AsTrait
{

    public static function as(?object $self): static
    {
        if (is_null($self)) {
            $backtrace = debug_backtrace(2);

            if (isset($backtrace[0]['file'], $backtrace[0]['line'])) {
                throw new \Exception(sprintf('Ожидался %s, а пришел null. Вызывал %s (%s)', static::class, $backtrace[0]['file'], $backtrace[0]['line']));
            }

            throw new \Exception(sprintf('Ожидался %s, а пришел null', static::class));
        }

        if (!($self instanceof static)) {
            throw new \Exception(sprintf('Ожидался %s, а пришел %s', static::class, get_class($self)));
        }

        return $self;
    }

    /**
     * @param array<object> $objects
     * @return array<static>
     */
    public static function manyAs(array $objects): array
    {
        return array_map(fn($object) => static::as($object), $objects);
    }

    public static function is(?object $self): bool
    {
        return $self instanceof static;
    }
}
