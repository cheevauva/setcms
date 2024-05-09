<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Scope;
use SetCMS\Module\Post\DAO\PostRetrieveBySlugDAO;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Attribute\Http\Parameter\Attributes;

class PostPublicReadBySlugScope extends Scope
{

    #[Attributes('slug')]
    public string $slug;
    //
    private ?PostEntity $post = null;

    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof PostRetrieveBySlugDAO) {
            $object->slug = $this->slug;
            $object->throwExceptionIfNotFound = true;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);
        
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
