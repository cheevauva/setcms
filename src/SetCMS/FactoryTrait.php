<?php

declare(strict_types=1);

namespace SetCMS;

trait FactoryTrait
{

    public static function factory(?object $builder = null): self
    {
        if ($builder instanceof FactoryInterface) {
            return $builder->make(static::class);
        }

        return new static;
    }

}
