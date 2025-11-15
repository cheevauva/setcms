<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use Module\Page\PageEntity;
use Module\Page\DAO\PageRetrieveManyByCriteriaDAO;
use Module\Page\View\PagePublicReadBlockView;

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
        $this->slug = $this->validation($this->params)->string('slug')->notEmpty()->notQuiet()->val();
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
