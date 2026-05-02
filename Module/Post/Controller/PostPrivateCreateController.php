<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostCreateDAO;
use Module\Post\View\PostPrivateCreateView;

class PostPrivateCreateController extends ControllerViaPSR7
{

    protected PostEntity $post;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostCreateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function fromRequest(): void
    {
        $body = $this->validationBody();
        $body->array('entity')->notEmpty()->validate();

        $this->post = new PostEntity();
        $this->post->id = $body->uuid('entity.id')->val();
        $this->post->slug = $body->string('entity.slug')->notEmpty()->val();
        $this->post->title = $body->string('entity.title')->notEmpty()->val();
        $this->post->message = $body->string('entity.message')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostCreateDAO) {
            $object->post = $this->post;
        }

        if ($object instanceof PostPrivateCreateView) {
            $object->entity = $this->post;
        }
    }
}
