<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

use Module\Post\Entity\PostEntity;

class PostToRowMapper extends \Module\Basic\Mapper\BasicEntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = PostEntity::as($this->entity);

        $this->row['slug'] = $entity->slug;
        $this->row['title'] = $entity->title;
        $this->row['message'] = $entity->message;

        parent::run();
    }
}
