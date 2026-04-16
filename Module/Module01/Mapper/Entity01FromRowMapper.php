<?php

declare(strict_types=1);

namespace Module\Module01\Mapper;

use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Exception\Entity01MapperNotFoundKeyInRowException;

class Entity01FromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\EntityFromRowMapperTrait;

    public Entity01Entity $entity01;

    #[\Override]
    public function serve(): void
    {
        $this->entity01 = Entity01Entity::as($this->newEntityByRow($this->row));

        $this->mapFields($this->row, $this->entity01);
    }

    protected function mapFields(): void
    {
        $this->entity01->field01 = strval($this->row['field01'] ?? throw $this->notFoundKeyInRowException('field01'));
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        return new Entity01MapperNotFoundKeyInRowException($key);
    }
}
