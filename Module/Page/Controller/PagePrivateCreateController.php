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
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('entity')->notEmpty()->validate();

        $this->page = new PageEntity();
        $this->page->id = $validation->uuid('entity.id')->val();
        $this->page->slug = $validation->string('entity.slug')->notEmpty()->val();
        $this->page->title = $validation->string('entity.title')->notEmpty()->val();
        $this->page->content = $validation->string('entity.content')->notEmpty()->val();
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
