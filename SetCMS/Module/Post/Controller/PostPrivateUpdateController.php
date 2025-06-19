<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\Servant\PostUpdateServant;
use SetCMS\Module\Post\View\PostPrivateUpdateView;

class PostPrivateUpdateController extends PostPrivateController
{

    protected PostEntity $post;
    protected PostEntity $newPost;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostRetrieveManyByCriteriaDAO::class,
            PostUpdateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPrivateUpdateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newPost = new PostEntity;
        $this->newPost->id = $validation->uuid('post.id')->notEmpty()->val();
        $this->newPost->slug = $validation->string('post.slug')->notEmpty()->val();
        $this->newPost->title = $validation->string('post.title')->notEmpty()->val();
        $this->newPost->message = $validation->string('post.message')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $object->id = $this->newPost->id;
            $object->orThrow = true;
        }

        if ($object instanceof PostUpdateServant) {
            $object->post = $this->post;
        }

        if ($object instanceof PostPrivateUpdateView) {
            $object->post = $this->post ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->post = PostEntity::as($object->post);
            $this->post->message = $this->newPost->message;
            $this->post->slug = $this->newPost->slug;
            $this->post->title = $this->newPost->title;
            $this->post->slug = $this->newPost->slug;
        }
    }
}
