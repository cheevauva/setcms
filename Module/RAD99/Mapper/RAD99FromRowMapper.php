<?php

declare(strict_types=1);

namespace Module\RAD99\Mapper;

use Module\RAD99\Entity\RAD99Entity;
use Module\Basic\Mapper\BasicEntityFromRowMapper;

/**
 * @extends BasicEntityFromRowMapper<RAD99Entity>
 */
class RAD99FromRowMapper extends BasicEntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = $this->entity = new RAD99Entity();
        $entity->field99 = $this->string('field99');

        parent::run();
    }
}
