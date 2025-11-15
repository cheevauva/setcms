<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use SetCMS\Mapper\EntityMapper;
use Module\Page\PageEntity;
use Module\Page\Exception\PageMapperException;

class PageMapper extends EntityMapper
{

    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = PageEntity::as($this->entity);

        $this->row['slug'] = $entity->slug;
        $this->row['title'] = $entity->title;
        $this->row['content'] = $entity->content;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = PageEntity::as($this->entity);
        $entity->slug = strval($this->row['slug'] ?? throw new PageMapperException('row.slug обязателен'));
        $entity->title = strval($this->row['title'] ?? throw new PageMapperException('row.title обязателен'));
        $entity->content = strval($this->row['content'] ?? throw new PageMapperException('row.content обязателен'));
    }
}
