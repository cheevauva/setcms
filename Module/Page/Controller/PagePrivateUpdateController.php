<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use Module\Page\PageEntity;
use Module\Page\DAO\PageRetrieveManyByCriteriaDAO;
use Module\Page\DAO\PageSaveDAO;
use Module\Page\View\PagePrivateUpdateView;

class PagePrivateUpdateController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected PageEntity $page;
    protected PageEntity $newPage;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageRetrieveManyByCriteriaDAO::class,
            PageSaveDAO::class,
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

        $this->newPage = new PageEntity();
        $this->newPage->id = $validation->uuid('page.id')->notEmpty()->val();
        $this->newPage->slug = $validation->string('page.slug')->notEmpty()->val();
        $this->newPage->title = $validation->string('page.title')->notEmpty()->val();
        $this->newPage->content = $validation->string('page.content')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $object->id = $this->newPage->id;
            $object->orThrow = true;
        }

        if ($object instanceof PageSaveDAO) {
            $object->page = $this->page;
        }

        if ($object instanceof PagePrivateUpdateView) {
            $object->page = $this->page;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $this->page = PageEntity::as($object->page);
            $this->page->content = $this->newPage->content;
            $this->page->slug = $this->newPage->slug;
            $this->page->title = $this->newPage->title;
        }
    }
}
