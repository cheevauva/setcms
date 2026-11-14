<?php

declare(strict_types=1);

namespace Module\Basic\Mapper;

use SetCMS\Entity\Mapper\EntityFromRowMapper;
use Module\Basic\Entity\BasicEntity;

/**
 * @template T of BasicEntity
 * @extends EntityFromRowMapper<T>
 */
abstract class BasicEntityFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = BasicEntity::as($this->entity);
        $entity->assignedBy = $this->uuid('assigned_by');
        $entity->createdBy = $this->uuid('created_by');
        $entity->modifiedBy = $this->uuid('modified_by');
        $entity->dateCreated = $this->dateTime('date_created');
        $entity->dateModified = $this->dateTime('date_modified');
        $entity->deleted = $this->bool('deleted');

        parent::run();
    }
}
