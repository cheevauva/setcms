<?php

declare(strict_types=1);

namespace SetCMS\Entity\Mapper;

use SetCMS\Entity\Entity;
use SetCMS\Entity\Exception\EntityMapperNotFoundKeyInRowException;

/**
 * @template T of Entity
 */
abstract class EntityFromRowMapper extends \SetCMS\Mapper\MapperFromRow
{

    /**
     * @var T
     */
    public protected(set) Entity $entity;

    #[\Override]
    protected function run(): void
    {
        $this->entity->id = $this->uuid('id');
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): EntityMapperNotFoundKeyInRowException
    {
        return new EntityMapperNotFoundKeyInRowException($key);
    }
}
