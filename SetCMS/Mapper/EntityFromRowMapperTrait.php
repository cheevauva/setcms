<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use Psr\Container\ContainerInterface;
use SetCMS\Entity\Entity;
use SetCMS\UUID;

trait EntityFromRowMapperTrait
{

    /**
     * @var array<string, mixed>
     */
    public array $row;

    /**
     * @param array<string, mixed> $row
     * @return Entity
     */
    protected function newEntityByRow(array $row): Entity
    {
        $entityType = strval($row['entity_type'] ?? throw $this->notFoundKeyInRowException('entity_type'));

        $className = $this->container->get('entities')[$entityType] ?? throw new \RuntimeException(sprintf('entities.%s не определен', $entityType));

        if (!class_exists($className, true)) {
            throw new \Exception(sprintf('entities.%s class %s not found', $row['entity_type'], $className));
        }

        $entity = Entity::as(new $className);
        $entity->id = new UUID(strval($row['id'] ?? throw $this->notFoundKeyInRowException('id')));

        return $entity;
    }

    abstract protected function notFoundKeyInRowException(string $key): \Throwable;

    /**
     * @param ContainerInterface $container
     * @param array<string, mixed> $row
     * @return static
     */
    public static function call(ContainerInterface $container, array $row): self
    {
        $self = static::new($container);
        $self->row = $row;
        $self->serve();

        return $self;
    }
}
