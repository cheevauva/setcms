<?php

declare(strict_types=1);

namespace SetCMS\Common\Mapper;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Common\Entity\Entity;
use SetCMS\UUID;

abstract class EntityMapper implements ContractServant
{

    public ?Entity $entity = null;
    public ?array $row = null;

    protected function entity(): Entity
    {
        return $this->entity;
    }

    public function serve(): void
    {
        if (empty($this->row)) {
            $this->entity2row();
        } else {
            $this->entity4row();
        }
    }

    protected function entity2row(): void
    {
        $this->row['id'] = (string) $this->entity->id;
        $this->row['entity_type'] = $this->entity->entityType;
        $this->row['date_created'] = $this->entity->dateCreated->format('Y-m-d H:i:s');
        $this->row['date_modified'] = $this->entity->dateModified->format('Y-m-d H:i:s');
        $this->row['deleted'] = intval($this->entity->deleted);
    }

    protected function entity4row(): void
    {
        if (empty($this->entity) && !class_exists($this->row['entity_type'])) {
            throw new \Exception(sprintf('row.entity_type(%s) not found', $this->row['entity_type']));
        }
        
        $this->entity = $this->entity ?? new $this->row['entity_type'];
        $this->entity->id = new UUID($this->row['id']);
        $this->entity->dateCreated = new \DateTime($this->row['date_created']);
        $this->entity->dateModified = new \DateTime($this->row['date_modified']);
        $this->entity->deleted = boolval($this->row['deleted']);
    }

}
