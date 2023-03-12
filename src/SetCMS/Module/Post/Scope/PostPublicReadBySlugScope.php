<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Scope;
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
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof PostRetrieveBySlugDAO) {
            $this->post = $object->post;
        }
    }

    public function toArray(): array
    {
        return [
            'post' => $this->post,
        ];
    }

}
