<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\Page\PageEntity;

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
        $entity->slug = $this->row['slug'];
        $entity->title = $this->row['title'];
        $entity->content = $this->row['content'];
    }
}
