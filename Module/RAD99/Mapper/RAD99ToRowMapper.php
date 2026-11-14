<?php

declare(strict_types=1);

namespace Module\RAD99\Mapper;

use Module\RAD99\Entity\RAD99Entity;

class RAD99ToRowMapper extends \Module\Basic\Mapper\BasicEntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        parent::run();
        
        $entity = RAD99Entity::as($this->entity);

        $this->row['field99'] = $entity->field99;
    }
}
