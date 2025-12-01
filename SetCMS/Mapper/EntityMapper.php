<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use SetCMS\Entity\Entity;
use SetCMS\UUID;
use SetCMS\Exception\EntityMapperNotFoundKeyInRowException;

abstract class EntityMapper extends \UUA\Servant
{

    public ?Entity $entity = null;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $row = null;

    public function serve(): void
    {
        if (!empty($this->row) && empty($this->entity)) {
            $this->entity4row();
        }

        if (empty($this->row) && !empty($this->entity)) {
            $this->entity2row();
        }
    }

    protected function entity2row(): void
    {
        if (empty($this->row)) {
            $this->row = [];
        }

        $entity = Entity::as($this->entity);

        $this->row['id'] = (string) $entity->id;
        $this->row['created_by'] = $entity->createdBy->uuid;
        $this->row['modified_by'] = $entity->modifiedBy->uuid;
        $this->row['assigned_by'] = $entity->assignedBy->uuid;
        $this->row['entity_type'] = array_search(get_class($entity), $this->container->get('entities')) ?: throw new \Exception(sprintf('%s не найдена', get_class($entity)));
        $this->row['date_created'] = $entity->dateCreated->format('Y-m-d H:i:s');
        $this->row['date_modified'] = $entity->dateModified->format('Y-m-d H:i:s');
        $this->row['deleted'] = intval($entity->deleted);
    }

    protected function entity4row(): void
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

        $entity = Entity::as(new $className);
        $entity->id = new UUID(strval($this->row['id'] ?? throw new \RuntimeException('id')));
        $entity->dateCreated = new \DateTimeImmutable(strval($this->row['date_created'] ?? throw new EntityMapperNotFoundKeyInRowException('date_created')));
        $entity->dateModified = new \DateTimeImmutable(strval($this->row['date_modified'] ?? throw new EntityMapperNotFoundKeyInRowException('date_modified')));
        $entity->deleted = boolval($this->row['deleted'] ?? throw new EntityMapperNotFoundKeyInRowException('deleted'));
        $entity->assignedBy = new UUID(strval($this->row['assigned_by'] ?? throw new EntityMapperNotFoundKeyInRowException('assigned_by')));
        $entity->createdBy = new UUID(strval($this->row['created_by'] ?? throw new EntityMapperNotFoundKeyInRowException('created_by')));
        $entity->modifiedBy = new UUID(strval($this->row['modified_by'] ?? throw new EntityMapperNotFoundKeyInRowException('modified_by')));
        
        $this->entity = $entity;
    }
}
