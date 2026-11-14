<?php

declare(strict_types=1);

namespace Module\Template\Mapper;

use SetCMS\Entity\Mapper\EntityToRowMapper;
use Module\Template\Entity\TemplateEntity;

class TemplateToRowMapper extends EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = TemplateEntity::as($this->entity);

        $this->row['template'] = $entity->template;
        $this->row['title'] = $entity->title;
        $this->row['slug'] = $entity->slug;

        parent::run();
    }
}
