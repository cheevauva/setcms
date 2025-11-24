<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use UUA\Mapper;
use SetCMS\Entity\Entity;
use SetCMS\UUID;

/**
 * @template T of Entity
 */
abstract class EntityFromRowMapper extends Mapper
{

    /**
     * @var T
     */
    public protected(set) Entity $entity;

    /**
     * @var array<string, mixed>
     */
    public array $row;

    #[\Override]
    public function serve(): void
    {

        if (empty($this->row['entity_type'])) {
            throw new \RuntimeException('row.entity_type is undefined');
        }

        if (!is_string($this->row['entity_type'])) {
            throw new \RuntimeException('row.entity_type must be string');
        }

        $className = $this->container->get('entities')[$this->row['entity_type']] ?? throw new \RuntimeException(sprintf('entities.%s undefined', $this->row['entity_type']));

        if (!class_exists($className, true)) {
            throw new \Exception(sprintf('entities.%s class %s not found', $this->row['entity_type'], $className));
        }

        /** @var T $entity * */
        $entity = Entity::as(new $className);
        $entity->id = new UUID(strval($this->row['id'] ?? throw new \RuntimeException('row.id is undefined')));
        $entity->dateCreated = new \DateTime(strval($this->row['date_created'] ?? throw new \RuntimeException('row.date_created is undefined')));
        $entity->dateModified = new \DateTime(strval($this->row['date_modified'] ?? throw new \RuntimeException('row.date_modified is undefined')));
        $entity->deleted = boolval($this->row['deleted'] ?? throw new \RuntimeException('row.deleted is undefined'));

        $this->entity = $entity;
    }
}
