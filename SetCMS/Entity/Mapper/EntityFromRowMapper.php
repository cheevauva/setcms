<?php

declare(strict_types=1);

namespace SetCMS\Entity\Mapper;

use SetCMS\Entity\Entity;
use SetCMS\Entity\Exception\EntityMapperNotFoundKeyInRowException;

abstract class EntityFromRowMapper extends \SetCMS\Mapper\MapperFromRow
{

    protected function id(Entity $entity): void
    {
        $entity->id = $this->uuid('id');
    }

    #[\Override]
    abstract protected function notFoundKeyInRowException(string $key): EntityMapperNotFoundKeyInRowException;
}
