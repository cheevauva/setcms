<?php

declare(strict_types=1);

namespace Module\Post\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Post\Entity\PostEntity;
use Module\Post\Servant\PostCreateServant;
use Module\Post\View\PostPrivateCreateView;

class PostPrivateCreateController extends ControllerViaPSR7
{

    protected PostEntity $entity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostCreateServant::class,
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
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('entity')->notEmpty()->validate();

        $this->entity = new PostEntity();
        $this->entity->id = $validation->uuid('entity.id')->val();
        $this->entity->slug = $validation->string('entity.slug')->notEmpty()->val();
        $this->entity->title = $validation->string('entity.title')->notEmpty()->val();
        $this->entity->message = $validation->string('entity.message')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostCreateServant) {
            $object->entity = $this->entity;
        }

        if ($object instanceof PostPrivateCreateView) {
            $object->entity = $this->entity;
        }
    }
}
