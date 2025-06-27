<?php

declare(strict_types=1);

namespace UUA\Traits;

use Psr\Container\ContainerInterface;
use UUA\FactoryInterface;

trait BuildTrait
{

    use AsTrait;

    final public static function new(ContainerInterface $container): static
    {
        $factory = $container->get(FactoryInterface::class);

        if (!is_object($factory)) {
            throw new \RuntimeException(sprintf('Ожидался объект для зависимости %s', FactoryInterface::class));
        }

        if (!($factory instanceof FactoryInterface)) {
            throw new \RuntimeException(sprintf('Ожидался %s для зависимости %s', FactoryInterface::class, get_class($factory)));
        }

        return static::as($factory->make(static::class));
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
