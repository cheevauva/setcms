<?php

declare(strict_types=1);

namespace Module\Module01\Mapper;

use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Exception\Entity01MapperNotFoundKeyInRowException;

class Entity01FromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    public Entity01Entity $entity01;

    #[\Override]
    public function serve(): void
    {
        $this->entity01 = new Entity01Entity();
        $this->entity01->field01 = $this->string('field01');
        $this->id($this->entity01);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): Entity01MapperNotFoundKeyInRowException
    {
        return new Entity01MapperNotFoundKeyInRowException($key);
    }
}
