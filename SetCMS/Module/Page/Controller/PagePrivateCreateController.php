<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\View\PagePrivateCreateView;
use SetCMS\Module\Page\DAO\PageSaveDAO;

class PagePrivateCreateController extends ControllerViaPSR7
{

    use \SetCMS\Module\User\Traits\UserCurrentTrait;

    protected PageEntity $page;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageSaveDAO::class,
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
        $validation->array('page')->notEmpty()->validate();

        $this->page = new PageEntity();
        $this->page->id = $validation->uuid('page.id')->val();
        $this->page->title = $validation->string('page.title')->notEmpty()->val();
        $this->page->slug = $validation->string('page.slug')->notEmpty()->val();
        $this->page->content = $validation->string('page.content')->notEmpty()->val();
        $this->page->createdUserId = $this->currentUser()->id;
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageSaveDAO) {
            $object->page = $this->page;
        }

        if ($object instanceof PagePrivateCreateView) {
            $object->page = $this->page;
        }
    }
}
