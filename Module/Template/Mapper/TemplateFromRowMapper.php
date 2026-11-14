<?php

declare(strict_types=1);

namespace Module\Template\Mapper;

use Module\Template\Entity\TemplateEntity;
use SetCMS\Entity\Mapper\EntityFromRowMapper;

/**
 * @extends EntityFromRowMapper<TemplateEntity>
 */
class TemplateFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = $this->entity = new TemplateEntity();
        $entity->entity = $this->string('entity');
        $entity->title = $this->string('title');
        $entity->slug = $this->string('slug');

        parent::run();
    }
}
