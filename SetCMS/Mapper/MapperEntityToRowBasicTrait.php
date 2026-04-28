<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use SetCMS\Entity\EntityBasic;

trait MapperEntityToRowBasicTrait
{

    use MapperEntityToRowTrait;

    private function mappingBasic(EntityBasic $entity): void
    {
        $this->row['entity_type'] = $entity::class;
        $this->row['created_by'] = $entity->createdBy->uuid;
        $this->row['modified_by'] = $entity->modifiedBy->uuid;
        $this->row['assigned_by'] = $entity->assignedBy->uuid;
        $this->row['date_created'] = $entity->dateCreated->format('Y-m-d H:i:s');
        $this->row['date_modified'] = $entity->dateModified->format('Y-m-d H:i:s');
        $this->row['deleted'] = intval($entity->deleted);
    }
}
