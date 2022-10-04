<?php

declare(strict_types=1);

namespace SetCMS;

use SetCMS\FactoryInterface;
use Psr\Container\ContainerInterface;

trait FactoryTrait
{

    /**
     * @param object|null $builder
     * @return static
     */
    public static function make(?object $builder = null)
    {
        if ($builder instanceof FactoryInterface) {
            return $builder->make(static::class);
        }
        
        if ($builder instanceof ContainerInterface) {
            return $builder->get(static::class);
        }

        return new static;
    }

}
