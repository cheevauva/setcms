<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Scope;
use SetCMS\Module\Post\DAO\PostEntityRetrieveBySlugDAO;
use SetCMS\Contract\Twigable;
use SetCMS\Module\Post\PostEntity;

class PostReadBySlugScope extends Scope implements Twigable
{

    public string $slug;
    private ?PostEntity $post = null;

    public function to(object $object): void
    {
        if ($object instanceof PostEntityRetrieveBySlugDAO) {
            $object->slug = $this->slug;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof PostEntityRetrieveBySlugDAO) {
            $this->post = $object->entity;
        }
    }

    public function toArray(): array
    {
        return [
            'post' => $this->post,
        ];
    }

}
