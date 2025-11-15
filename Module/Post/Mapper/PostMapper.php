<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

use SetCMS\Common\Mapper\EntityMapper;
use Module\Post\PostEntity;
use Module\Post\Exception\PostMapperException;

class PostMapper extends EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        parent::entity2row();

        $entity = PostEntity::as($this->entity);

        $this->row['message'] = $entity->message;
        $this->row['slug'] = $entity->slug;
        $this->row['title'] = $entity->title;
    }

    #[\Override]
    protected function entity4row(): void
    {
        parent::entity4row();

        $entity = PostEntity::as($this->entity);
        $entity->message = strval($this->row['message'] ?? throw new PostMapperException('row.message обязательный'));
        $entity->title = strval($this->row['title'] ?? throw new PostMapperException('row.title обязательный'));
        $entity->slug = strval($this->row['slug'] ?? throw new PostMapperException('row.slug обязательный'));
    }
}
