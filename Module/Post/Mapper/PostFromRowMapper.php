<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

use Module\Post\Entity\PostEntity;
use Module\Post\Exception\PostMapperNotFoundKeyInRowException;

class PostFromRowMapper extends \UUA\Mapper
{
    use \SetCMS\Mapper\EntityFromRowMapperTrait;
    use \SetCMS\Mapper\EntityFromRowBasicMapperTrait;
    
    public protected(set) PostEntity $post;

    #[\Override]
    public function serve(): void
    {
        $this->post = PostEntity::as($this->newEntityByRow($this->row));
        $this->post->slug = strval($this->row['slug'] ?? throw $this->notFoundKeyInRowException('slug'));
        $this->post->title = strval($this->row['title'] ?? throw $this->notFoundKeyInRowException('title'));
        $this->post->message = strval($this->row['message'] ?? throw $this->notFoundKeyInRowException('message'));
        
        $this->mapperBasic($this->row, $this->post);
        
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        return new PostMapperNotFoundKeyInRowException($key);
    }
}
