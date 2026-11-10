<?php

declare(strict_types=1);

namespace Module\RAD01\Traits;

use Psr\Container\ContainerInterface;
use Module\RAD01\Entity\RAD01Entity;
use UUA\WithContainterInterface;

trait RAD01CallTrait
{

    public RAD01Entity $rad01;

    public static function call(WithContainterInterface|ContainerInterface $container, RAD01Entity $rad01): self
    {
        $self = self::new($container);
        $self->rad01 = $rad01;
        $self->serve();

        return $self;
    }
}
