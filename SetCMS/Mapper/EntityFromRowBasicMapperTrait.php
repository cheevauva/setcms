<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use SetCMS\Entity\EntityBasic;
use SetCMS\UUID;

trait EntityFromRowBasicMapperTrait
{

    abstract protected function notFoundKeyInRowException(string $key): \Throwable;

    /**
     * 
     * @param array<string, mixed> $row
     * @param EntityBasic $entity
     * @return void
     */
    public function mapperBasic(array $row, EntityBasic $entity): void
    {
        $entity->assignedBy = new UUID(strval($row['assigned_by'] ?? throw $this->notFoundKeyInRowException('assigned_by')));
        $entity->createdBy = new UUID(strval($row['created_by'] ?? throw $this->notFoundKeyInRowException('created_by')));
        $entity->modifiedBy = new UUID(strval($row['modified_by'] ?? throw $this->notFoundKeyInRowException('modified_by')));
        $entity->dateCreated = new \DateTimeImmutable(strval($row['date_created'] ?? throw $this->notFoundKeyInRowException('date_created')));
        $entity->dateModified = new \DateTimeImmutable(strval($row['date_modified'] ?? throw $this->notFoundKeyInRowException('date_modified')));
        $entity->deleted = boolval($row['deleted'] ?? throw $this->notFoundKeyInRowException('deleted'));
    }
}
