<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

use Module\Post\Entity\PostEntity;
use Module\Basic\Mapper\BasicEntityFromRowMapper;

/**
 * @extends BasicEntityFromRowMapper<PostEntity>
 */
class PostFromRowMapper extends BasicEntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $entity = $this->entity = new PostEntity;
        $entity->slug = $this->string('slug');
        $entity->title = $this->string('title');
        $entity->message = $this->string('message');

        parent::run();
    }
}
