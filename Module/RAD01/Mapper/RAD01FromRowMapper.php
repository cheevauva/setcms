<?php

declare(strict_types=1);

namespace Module\RAD01\Mapper;

use Module\RAD01\Entity\RAD01Entity;
use SetCMS\Entity\Mapper\EntityFromRowMapper;

/**
 * @extends EntityFromRowMapper<RAD01Entity>
 */
class RAD01FromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = $this->entity = new RAD01Entity();
        $entity->field01 = $this->string('field01');

        parent::run();
    }
}
