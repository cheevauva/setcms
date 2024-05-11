<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Scope;

use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostRetrieveByIdDAO;
use SetCMS\Module\Post\Servant\PostUpdateServant;
use SetCMS\Attribute\Http\Parameter\Body;

class PostPrivateUpdateScope extends PostPrivateScope
{

    protected ?PostEntity $entity = null;

    #[Body('post')]
    public PostPrivatePostScope $post;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveByIdDAO) {
            $this->entity = new PostEntity;
            $this->post->to($this->entity);
            $object->id = $this->entity->id;
        }

        if ($object instanceof PostUpdateServant) {
            $this->post->to($this->entity);
            $object->post = $this->entity;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveByIdDAO) {
            $this->entity = $object->post;
        }
    }

    public function toArray(): array
    {
        return [
            'post' => $this->entity,
        ];
    }

}
