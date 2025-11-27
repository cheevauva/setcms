<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

use SetCMS\Mapper\EntityFromRowMapper;
use Module\Post\Entity\PostEntity;
use Module\Post\Exception\PostMapperNotFoundKeyInRowException;

/**
 * @extends EntityFromRowMapper<PostEntity>
 */
class PostFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $post = PostEntity::as($this->entity);
        $post->slug = strval($this->row['slug'] ?? throw new PostMapperNotFoundKeyInRowException('slug'));
        $post->title = strval($this->row['title'] ?? throw new PostMapperNotFoundKeyInRowException('title'));
        $post->message = strval($this->row['message'] ?? throw new PostMapperNotFoundKeyInRowException('message'));
    }
}
