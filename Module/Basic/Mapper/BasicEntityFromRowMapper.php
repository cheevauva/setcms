<?php

declare(strict_types=1);

namespace Module\Basic\Mapper;

use Module\Basic\Entity\BasicEntity;

abstract class BasicEntityFromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    protected function basic(BasicEntity $entity): void
    {
        $entity->assignedBy = $this->uuid('assigned_by');
        $entity->createdBy = $this->uuid('created_by');
        $entity->modifiedBy = $this->uuid('modified_by');
        $entity->dateCreated = $this->dateTime('date_created');
        $entity->dateModified = $this->dateTime('date_modified');
        $entity->deleted = $this->bool('deleted');
    }
}
