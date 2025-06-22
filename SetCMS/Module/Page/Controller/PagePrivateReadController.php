<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\UUID;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveManyByCriteriaDAO;
use SetCMS\Module\Page\View\PagePrivateReadView;
use SetCMS\Application\Router\RouterMatchDTO;

class PagePrivateReadController extends ControllerViaPSR7
{

    protected ?PageEntity $page = null;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePrivateReadView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $routerMatch = RouterMatchDTO::as($this->ctx['routerMatch']);

        $this->id = $this->validation($routerMatch->params)->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->limit = 1;
        }

        if ($object instanceof PagePrivateReadView) {
            $object->page = $this->page;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $this->page = $object->page;
        }
    }
}
