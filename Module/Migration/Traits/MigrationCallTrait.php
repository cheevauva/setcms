<?php

declare(strict_types=1);

namespace Module\Migration\Traits;

use Module\Migration\Entity\MigrationEntity;
use Psr\Container\ContainerInterface;

trait MigrationCallTrait
{

    public MigrationEntity $migration;

    /**
     * @param ContainerInterface $container
     * @param MigrationEntity $migration
     * @return static
     */
    public static function call(ContainerInterface $container, MigrationEntity $migration): self
    {
        $self = self::new($container);
        $self->migration = $migration;
        $self->serve();

        return $self;
    }
}
