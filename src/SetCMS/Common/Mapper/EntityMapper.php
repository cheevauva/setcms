<?php

declare(strict_types=1);

namespace SetCMS\Common\Mapper;

use SetCMS\Common\Entity\Entity;
use SetCMS\UUID;

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
        $this->row['entity_type'] = $entity->entityType;
        $this->row['date_created'] = $entity->dateCreated->format('Y-m-d H:i:s');
        $this->row['date_modified'] = $entity->dateModified->format('Y-m-d H:i:s');
        $this->row['deleted'] = intval($entity->deleted);
    }

    protected function entity4row(): void
    {
        if (empty($this->entity)) {
            if (empty($this->row['entity_type'])) {
                throw new \RuntimeException('row.entity_type is undefined');
            }

            if (!is_string($this->row['entity_type'])) {
                throw new \RuntimeException('row.entity_type must be string');
            }

            if (!class_exists($this->row['entity_type'])) {
                throw new \Exception(sprintf('row.entity_type(%s) not found', $this->row['entity_type']));
            }

            $entity = Entity::as(new $this->row['entity_type']);
        } else {
            $entity = Entity::as($this->entity);
        }
        
        $entity->id = new UUID(strval($this->row['id'] ?? throw new \RuntimeException('row.id is undefined')));
        $entity->dateCreated = new \DateTime(strval($this->row['date_created'] ?? throw new \RuntimeException('row.date_created is undefined')));
        $entity->dateModified = new \DateTime(strval($this->row['date_modified'] ?? throw new \RuntimeException('row.date_modified is undefined')));
        $entity->deleted = boolval($this->row['deleted'] ?? throw new \RuntimeException('row.deleted is undefined'));
        
        $this->entity = $entity;
    }
}
