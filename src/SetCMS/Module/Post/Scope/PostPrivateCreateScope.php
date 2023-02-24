<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\Servant\PostCreateServant;

class PostPrivateCreateScope extends PostPrivateScope
{

    protected ?PostEntity $entity = null;
    public PostPrivatePostScope $post;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostCreateServant) {
            $this->entity = new PostEntity;
            $this->post->to($this->entity);
            $object->post = $this->entity;
        }
    }

    public function toArray(): array
    {
        return [
            'post' => $this->entity,
        ];
    }

}
