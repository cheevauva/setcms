<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use UUA\Mapper;
use SetCMS\Entity\Entity;

/**
 * @template T of Entity
 */
abstract class EntityToRowMapper extends Mapper
{

    /**
     * @var T
     */
    public $entity;

    /**
     * @var array<string, mixed>
     */
    public protected(set) array $row;

    #[\Override]
    public function serve(): void
    {
        $this->row = [];
        
        $entity = Entity::as($this->entity);

        $this->row['id'] = (string) $entity->id;
        $this->row['entity_type'] = array_search($entity->entityType, $this->container->get('entities')) ?: throw new \Exception(sprintf('%s не найдена', $entity->entityType));
        $this->row['date_created'] = $entity->dateCreated->format('Y-m-d H:i:s');
        $this->row['date_modified'] = $entity->dateModified->format('Y-m-d H:i:s');
        $this->row['deleted'] = intval($entity->deleted);
    }
}
