<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use SetCMS\Entity\Entity;

trait EntityToRowMapperTrait
{

    /**
     * @var array<string, mixed>
     */
    public protected(set) array $row;

    public function map(Entity $entity): void
    {
        $this->row['id'] = $entity->id->uuid;
    }
}
