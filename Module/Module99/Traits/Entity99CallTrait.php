<?php

declare(strict_types=1);

namespace Module\Module99\Traits;

use Psr\Container\ContainerInterface;
use Module\Module99\Entity\Entity99Entity;

trait Entity99CallTrait
{

    public Entity99Entity $entity99;

    /**
     * @param ContainerInterface $container
     * @param Entity99Entity $entity99
     * @return static
     */
    public static function call(ContainerInterface $container, Entity99Entity $entity99): self
    {
        $self = self::new($container);
        $self->entity99 = $entity99;
        $self->serve();

        return $self;
    }
}
