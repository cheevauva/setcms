<?php

declare(strict_types=1);

namespace SetCMS\Entity\Traits;

use Psr\Container\ContainerInterface;
use UUA\WithContainterInterface;
use SetCMS\Entity\Entity;

trait EntityCallTrait
{

    public Entity $entity;

    public static function call(WithContainterInterface|ContainerInterface $container, Entity $entity): static
    {
        $self = static::as(static::new($container));
        $self->entity = $entity;
        $self->serve();

        return $self;
    }
}
