<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Page\Entity\PageEntity;
use Module\Page\Servant\PageCreateServant;
use Module\Page\View\PagePrivateCreateView;

class PagePrivateCreateController extends ControllerViaPSR7
{

    protected PageEntity $entity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageCreateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('entity')->notEmpty()->validate();

        $this->entity = new PageEntity();
        $this->entity->id = $validation->uuid('entity.id')->val();
        $this->entity->slug = $validation->string('entity.slug')->notEmpty()->val();
        $this->entity->title = $validation->string('entity.title')->notEmpty()->val();
        $this->entity->content = $validation->string('entity.content')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageCreateServant) {
            $object->entity = $this->entity;
        }

        if ($object instanceof PagePrivateCreateView) {
            $object->entity = $this->entity;
        }
    }
}
