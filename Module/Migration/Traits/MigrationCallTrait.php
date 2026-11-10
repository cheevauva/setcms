<?php

declare(strict_types=1);

namespace Module\Migration\Traits;

use Module\Migration\Entity\MigrationEntity;
use Psr\Container\ContainerInterface;
use UUA\WithContainterInterface;

trait MigrationCallTrait
{

    public MigrationEntity $migration;

    public static function call(WithContainterInterface|ContainerInterface $container, MigrationEntity $migration): self
    {
        $self = self::new($container);
        $self->migration = $migration;
        $self->serve();

        return $self;
    }
}
