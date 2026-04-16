<?php

declare(strict_types=1);

namespace Module\Module99\Mapper;

use Module\Module99\Entity\Entity99Entity;
use Module\Module99\Exception\Entity99MapperNotFoundKeyInRowException;

class Entity99FromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\EntityFromRowMapperTrait;
    use \SetCMS\Mapper\EntityFromRowBasicMapperTrait;

    public Entity99Entity $entity99;

    #[\Override]
    public function serve(): void
    {
        $this->entity99 = Entity99Entity::as($this->newEntityByRow($this->row));
        $this->entity99->field99 = strval($this->row['field99'] ?? throw $this->notFoundKeyInRowException('field99'));

        $this->mapperBasic($this->row, $this->entity99);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        return new Entity99MapperNotFoundKeyInRowException($key);
    }
}
