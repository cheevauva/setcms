<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\Servant\PostUpdateServant;
use SetCMS\Attribute\Http\Parameter\Body;
use SetCMS\Attribute\ResponderPassProperty;
use SetCMS\Attribute\Http\RequestMethod;

#[RequestMethod('POST')]
class PostPrivateUpdateController extends PostPrivateController
{

    #[ResponderPassProperty('post')]
    protected ?PostEntity $entity = null;

    #[Body('post')]
    public PostPrivatePostController $post;

    #[\Override]
    protected function units(): array
    {
        return [
            PostRetrieveManyByCriteriaDAO::class,
            PostUpdateServant::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->entity = new PostEntity;
            $this->post->to($this->entity);
            $object->id = $this->entity->id;
        }

        if ($object instanceof PostUpdateServant) {
            $this->post->to($this->entity);
            $object->post = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->entity = $object->post;
        }
    }
}
