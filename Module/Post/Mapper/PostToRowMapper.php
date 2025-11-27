<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

use SetCMS\Mapper\EntityToRowMapper;
use Module\Post\Entity\PostEntity;

/**
 * @extends EntityToRowMapper<PostEntity>
 */
class PostToRowMapper extends EntityToRowMapper
{

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $post = PostEntity::as($this->entity);

        $this->row['slug'] = $post->slug;
        $this->row['title'] = $post->title;
        $this->row['message'] = $post->message;
    }
}
