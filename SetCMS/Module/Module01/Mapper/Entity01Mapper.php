<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\Module01\Entity\Entity01Entity;
use SetCMS\Module\Module01\Exception\Entity01MapperException;

class Entity01Mapper extends EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = Entity01Entity::as($this->entity);

        $this->row['field01'] = $entity->field01;
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = Entity01Entity::as($this->entity);
        $entity->field01 = strval($this->row['field01'] ?? throw new Entity01MapperException('row.field01 обязателен'));
    }
}
