<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageCreateDAO;
use Module\Page\View\PagePrivateCreateView;

class PagePrivateCreateController extends ControllerViaPSR7
{

    private PageEntity $page;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageCreateDAO::class,
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
    protected function fromRequest(): void
    {
        $body = $this->validationBody();
        $body->array('entity')->notEmpty()->validate();

        $this->page = new PageEntity();
        $this->page->id = $body->uuid('entity.id')->val();
        $this->page->slug = $body->string('entity.slug')->notEmpty()->val();
        $this->page->title = $body->string('entity.title')->notEmpty()->val();
        $this->page->content = $body->string('entity.content')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageCreateDAO) {
            $object->page = $this->page;
        }

        if ($object instanceof PagePrivateCreateView) {
            $object->entity = $this->page;
        }
    }
}
