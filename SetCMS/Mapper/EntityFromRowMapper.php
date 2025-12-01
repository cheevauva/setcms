<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use UUA\Mapper;
use SetCMS\Entity\Entity;
use SetCMS\UUID;
use SetCMS\Exception\EntityMapperNotFoundKeyInRowException;

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

        $entityType = strval($this->row['entity_type'] ?? throw new EntityMapperNotFoundKeyInRowException('entity_type'));

        $className = $this->container->get('entities')[$entityType] ?? throw new \RuntimeException(sprintf('entities.%s не определен', $entityType));

        if (!class_exists($className, true)) {
            throw new \Exception(sprintf('entities.%s class %s not found', $this->row['entity_type'], $className));
        }

        $entity = Entity::as(new $className);
        $entity->id = new UUID(strval($this->row['id'] ?? throw new EntityMapperNotFoundKeyInRowException('id')));
        $entity->assignedBy = new UUID(strval($this->row['assigned_by'] ?? throw new EntityMapperNotFoundKeyInRowException('assigned_by')));
        $entity->createdBy = new UUID(strval($this->row['created_by'] ?? throw new EntityMapperNotFoundKeyInRowException('created_by')));
        $entity->modifiedBy = new UUID(strval($this->row['modified_by'] ?? throw new EntityMapperNotFoundKeyInRowException('modified_by')));
        $entity->dateCreated = new \DateTimeImmutable(strval($this->row['date_created'] ?? throw new EntityMapperNotFoundKeyInRowException('date_created')));
        $entity->dateModified = new \DateTimeImmutable(strval($this->row['date_modified'] ?? throw new EntityMapperNotFoundKeyInRowException('date_modified')));
        $entity->deleted = boolval($this->row['deleted'] ?? throw new EntityMapperNotFoundKeyInRowException('deleted'));
        
        /** @var T $entity * */
        $this->entity = $entity;
    }
}
