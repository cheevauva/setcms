<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\Template\Entity\TemplateEntity;
use SetCMS\Module\Template\Exception\TemplateMapperException;

class TemplateMapper extends EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = TemplateEntity::as($this->entity);

        $this->row['template'] = $entity->template;
        $this->row['title'] = $entity->title;
        $this->row['slug'] = $entity->slug;
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = TemplateEntity::as($this->entity);
        $entity->template = strval($this->row['template'] ?? throw new TemplateMapperException('row.template обязателен'));
        $entity->title = strval($this->row['title'] ?? throw new TemplateMapperException('row.title обязателен'));
        $entity->slug = strval($this->row['slug'] ?? throw new TemplateMapperException('row.slug обязателен'));
    }
}
