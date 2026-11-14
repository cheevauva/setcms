<?php

declare(strict_types=1);

namespace Module\RAD01\Mapper;

use Module\RAD01\Entity\RAD01Entity;

class RAD01ToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = RAD01Entity::as($this->entity);
        
        $this->row['field01'] = $entity->field01;

        parent::run();
    }
}
