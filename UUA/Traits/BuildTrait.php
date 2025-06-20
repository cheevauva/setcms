<?php

declare(strict_types=1);

namespace UUA\Traits;

use Psr\Container\ContainerInterface;

trait BuildTrait
{

    use AsTrait;

    final public static function new(ContainerInterface $container): static
    {
        $className = ($container->get('fake') ?: [])[static::class] ?? static::class;
        
        if (is_callable($className)) { 
            return static::as($className($container));
        }

        return static::as(new $className($container));
    }

    public static function singleton(ContainerInterface $container): static
    {
        $signleton = $container->get(static::class);

        if (!is_object($signleton)) {
            throw new \RuntimeException(sprintf('Ожидался объект для зависимости %s', static::class));
        }

        return static::as($signleton);
    }
}
