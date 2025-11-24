<?php

declare(strict_types=1);

namespace Module\Module01\Mapper;

use SetCMS\Mapper\EntityToRowMapper;
use Module\Module01\Entity\Entity01Entity;

/**
 * @extends EntityToRowMapper<Entity01Entity>
 */
class Entity01ToRowMapper extends EntityToRowMapper
{

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $entity01lc = Entity01Entity::as($this->entity);

        $this->row['field01'] = $entity01lc->field01;
    }
}
