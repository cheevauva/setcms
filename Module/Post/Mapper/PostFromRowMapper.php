<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

use Module\Post\Entity\PostEntity;
use Module\Post\Exception\PostMapperNotFoundKeyInRowException;

class PostFromRowMapper extends \SetCMS\Entity\Mapper\EntityBasicFromRowMapper
{

    public protected(set) PostEntity $post;

    #[\Override]
    public function serve(): void
    {
        $this->post = new PostEntity;
        $this->post->slug = $this->string('slug');
        $this->post->title = $this->string('title');
        $this->post->message = $this->string('message');
        $this->id($this->post);
        $this->basic($this->post);
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): PostMapperNotFoundKeyInRowException
    {
        return new PostMapperNotFoundKeyInRowException($key);
    }
}
