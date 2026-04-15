<?php

declare(strict_types=1);

namespace Module\Module01\Traits;

use Psr\Container\ContainerInterface;
use Module\Module01\Entity\Entity01Entity;

trait Entity01CallTrait
{

    public Entity01Entity $entity01;

    /**
     * @param ContainerInterface $container
     * @param Entity01Entity $entity01
     * @return static
     */
    public static function call(ContainerInterface $container, Entity01Entity $entity01): self
    {
        $self = self::new($container);
        $self->entity01 = $entity01;
        $self->serve();

        return $self;
    }
}
