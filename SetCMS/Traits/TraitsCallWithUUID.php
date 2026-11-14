<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use Psr\Container\ContainerInterface;
use UUA\WithContainterInterface;
use SetCMS\UUID;

trait TraitsCallWithUUID
{

    public UUID $id;

    public static function call(WithContainterInterface|ContainerInterface $container, UUID $id): static
    {
        $self = static::new($container);
        $self->id = $id;
        $self->serve();

        return $self;
    }
}
