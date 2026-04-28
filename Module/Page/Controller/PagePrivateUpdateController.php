<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Page\Entity\PageEntity;
use Module\Page\Servant\PageGetByIdServant;
use Module\Page\DAO\PageUpdateDAO;
use Module\Page\View\PagePrivateUpdateView;

class PagePrivateUpdateController extends ControllerViaPSR7
{

    public PageEntity $page;
    public PageEntity $newPage;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageGetByIdServant::class,
            PageUpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePrivateUpdateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newPage = new PageEntity;
        $this->newPage->id = $validation->uuid('entity.id')->notEmpty()->val();
        $this->newPage->slug = $validation->string('entity.slug')->notEmpty()->val();
        $this->newPage->title = $validation->string('entity.title')->notEmpty()->val();
        $this->newPage->content = $validation->string('entity.content')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageGetByIdServant) {
            $object->id = $this->newPage->id;
        }

        if ($object instanceof PageUpdateDAO) {
            $object->page = $this->page;
            $object->page->slug = $this->newPage->slug;
            $object->page->title = $this->newPage->title;
            $object->page->content = $this->newPage->content;
        }

        if ($object instanceof PagePrivateUpdateView) {
            $object->entity = $this->page;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageGetByIdServant) {
            $this->page = $object->page;
        }
    }
}
