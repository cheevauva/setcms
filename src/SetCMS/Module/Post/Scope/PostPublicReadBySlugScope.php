<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Scope;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\DAO\PostRetrieveBySlugDAO;
use SetCMS\Module\Post\PostEntity;

class PostPublicReadBySlugScope extends Scope
{

    public string $slug;
    private ?PostEntity $post = null;

    public function to(object $object): void
    {
        if ($object instanceof PostRetrieveBySlugDAO) {
            $object->slug = $this->slug;
            $object->throwExceptionIfNotFound = true;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof PostRetrieveBySlugDAO) {
            $this->post = $object->post;
        }
        
        if ($object instanceof ServerRequestInterface) {
            $this->slug = $object->getAttribute('slug', null);
        }
    }

    public function toArray(): array
    {
        return [
            'post' => $this->post,
        ];
    }

}
