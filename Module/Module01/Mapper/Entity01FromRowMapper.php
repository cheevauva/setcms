<?php

declare(strict_types=1);

namespace Module\Module01\Mapper;

use SetCMS\Mapper\EntityFromRowMapper;
use Module\Module01\Entity\Entity01Entity;
use SetCMS\Exception\EntityMapperNotFoundKeyInRowException;
use Module\Module01\Exception\Entity01MapperNotFoundKeyInRowException;

/**
 * @extends EntityFromRowMapper<Entity01Entity>
 */
class Entity01FromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    public function serve(): void
    {

        try {
            parent::serve();
        } catch (EntityMapperNotFoundKeyInRowException $ex) {
            throw new Entity01MapperNotFoundKeyInRowException($ex->key);
        }
        
        $entity01lc = Entity01Entity::as($this->entity);
        $entity01lc->field01 = strval($this->row['field01'] ?? throw new Entity01MapperNotFoundKeyInRowException('field01'));
    }
}
