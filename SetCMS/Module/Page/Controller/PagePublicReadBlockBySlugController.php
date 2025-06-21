<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Controller;

use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageRetrieveManyByCriteriaDAO;
use SetCMS\Module\Page\View\PagePublicReadBlockView;
use SetCMS\Application\Router\RouterMatchDTO;

class PagePublicReadBlockBySlugController extends \SetCMS\ControllerViaPSR7
{

    protected string $slug;
    protected ?PageEntity $page = null;

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
            PagePublicReadBlockView::class,
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
            $object->orThrow = false;
            $object->slug = $this->slug;
            $object->limit = 1;
        }

        if ($object instanceof PagePublicReadBlockView) {
            $object->page = $this->page;
            $object->slug = $this->slug;
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
