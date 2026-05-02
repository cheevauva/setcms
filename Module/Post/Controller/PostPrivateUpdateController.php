<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostGetByIdDAO;
use Module\Post\DAO\PostUpdateDAO;
use Module\Post\View\PostPrivateUpdateView;

class PostPrivateUpdateController extends ControllerViaPSR7
{

    protected PostEntity $post;
    private PostEntity $newPost;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostGetByIdDAO::class,
            PostUpdateDAO::class,
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
    protected function fromRequest(): void
    {
        $body = $this->validationBody();

        $this->newPost = new PostEntity;
        $this->newPost->id = $body->uuid('entity.id')->notEmpty()->val();
        $this->newPost->slug = $body->string('entity.slug')->notEmpty()->val();
        $this->newPost->title = $body->string('entity.title')->notEmpty()->val();
        $this->newPost->message = $body->string('entity.message')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostGetByIdDAO) {
            $object->id = $this->newPost->id;
        }

        if ($object instanceof PostUpdateDAO) {
            $object->post = $this->post;
            $object->post->slug = $this->newPost->slug;
            $object->post->title = $this->newPost->title;
            $object->post->message = $this->newPost->message;
        }

        if ($object instanceof PostPrivateUpdateView) {
            $object->entity = $this->entity ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostGetByIdDAO) {
            $this->post = $object->post;
        }
    }
}
