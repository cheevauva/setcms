<?php

declare(strict_types=1);

namespace SetCMS\Entity\Mapper;

use SetCMS\Entity\EntityBasic;

abstract class EntityBasicToRowMapper extends EntityToRowMapper
{

    protected function basic(EntityBasic $entity): void
    {
        $this->row['created_by'] = $entity->createdBy->uuid;
        $this->row['modified_by'] = $entity->modifiedBy->uuid;
        $this->row['assigned_by'] = $entity->assignedBy->uuid;
        $this->row['entity_type'] = $entity::class;
        $this->row['date_created'] = $entity->dateCreated->format('Y-m-d H:i:s');
        $this->row['date_modified'] = $entity->dateModified->format('Y-m-d H:i:s');
        $this->row['deleted'] = intval($entity->deleted);
    }
}
