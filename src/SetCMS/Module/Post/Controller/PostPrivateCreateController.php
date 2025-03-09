<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\Servant\PostCreateServant;
use SetCMS\Attribute\Http\Parameter\Body;
use SetCMS\Attribute\ResponderPassProperty;
use SetCMS\Attribute\Http\RequestMethod;

#[RequestMethod('POST')]
class PostPrivateCreateController extends PostPrivateController
{

    #[ResponderPassProperty('post')]
    protected ?PostEntity $entity = null;

    #[Body('post')]
    public PostPrivatePostController $post;

    #[\Override]
    protected function units(): array
    {
        return [
            PostCreateServant::class,
        ];
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostCreateServant) {
            $this->entity = new PostEntity;
            $this->post->to($this->entity);
            $object->post = $this->entity;
        }
    }
}
