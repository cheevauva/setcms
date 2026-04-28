<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use SetCMS\Entity\EntityBasic;

trait MapperEntityFromRowBasicTrait
{

    use MapperEntityFromRowTrait;

    private function mappingBasic(EntityBasic $entity): void
    {
        $entity->assignedBy = $this->uuid('assigned_by');
        $entity->createdBy = $this->uuid('created_by');
        $entity->modifiedBy = $this->uuid('modified_by');
        $entity->dateCreated = $this->dateTime('date_created');
        $entity->dateModified = $this->dateTime('date_modified');
        $entity->deleted = $this->bool('deleted');
    }
}
