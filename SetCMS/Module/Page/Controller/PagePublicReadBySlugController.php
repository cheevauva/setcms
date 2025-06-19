<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveManyByCriteriaDAO;
use SetCMS\Module\Page\View\PagePublicReadView;
use SetCMS\Application\Router\RouterMatchDTO;

class PagePublicReadBySlugController extends \SetCMS\ControllerViaPSR7
{

    protected string $slug;
    protected PageEntity $page;

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
            PagePublicReadView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $routerMatch = RouterMatchDTO::as($this->ctx['routerMatch']);

        $this->slug = $this->validation($routerMatch->params)->string('slug')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $object->orThrow = true;
            $object->slug = $this->slug;
            $object->limit = 1;
        }

        if ($object instanceof PagePublicReadView) {
            $object->page = $this->page;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $this->page = PageEntity::as($object->page);
        }
    }
}
