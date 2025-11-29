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
    public Entity $entity;

    /**
     * @var array<string, mixed>
     */
    public protected(set) array $row;

    #[\Override]
    public function serve(): void
    {
        $entity = $this->entity;
        
        $this->row = [];
        $this->row['id'] = $entity->id->uuid;
        $this->row['entity_type'] = array_search(get_class($entity), $this->container->get('entities')) ?: throw new \Exception(sprintf('%s не найдена', get_class($entity)));
        $this->row['date_created'] = $entity->dateCreated->format('Y-m-d H:i:s');
        $this->row['date_modified'] = $entity->dateModified->format('Y-m-d H:i:s');
        $this->row['deleted'] = intval($entity->deleted);
    }
}
