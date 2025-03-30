<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Module\Post\PostEntity;

class PostMapper extends EntityMapper
{

    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = PostEntity::as($this->entity);

        $this->row['message'] = $entity->message;
        $this->row['slug'] = $entity->slug;
        $this->row['title'] = $entity->title;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = PostEntity::as($this->entity);
        $entity->message = $this->row['message'];
        $entity->title = $this->row['title'];
        $entity->slug = $this->row['slug'];
    }
}
